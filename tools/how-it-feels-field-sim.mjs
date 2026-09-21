// How it feels — phone field simulation (21 Sep 2026).
//
// A Node port of the placement (spiral) and commit (make-room) maths in
// sweet-pepper-theme/src/js/how-it-feels.js, for tuning FIELD_AREA_PHONE without
// rebuild-and-tap cycles. Sweeps every field width 288–398px and reports, per area factor:
// the field height at four phone widths, the share of taps that centre fully, and how many
// widths had to grow past the factor's height to seat every word.
//
//   node tools/how-it-feels-field-sim.mjs                         all 16 words
//   node tools/how-it-feels-field-sim.mjs wonderful,charming      with these words dropped
//
// ALL = [key, width, height] measured on the page at 402px (Molot 40 / 26 / 18, 2px padding).
// Re-measure when the phone sizes, the words or the language change:
//   [...document.querySelectorAll('.about-cloud-word')].map(e => [e.dataset.key, e.offsetWidth, e.offsetHeight])
// Keep the maths in step with how-it-feels.js — this file is a copy, not an import.
const ALL=[['cosy',89,48],['welcoming',210,48],['beloved',102,33],['friendly',166,48],['happy',77,33],['attentive',83,24],['perfect',99,33],['inviting',152,48],['magnetic',116,33],['sociable',108,33],['wonderful',139,33],['lively',52,24],['pleasant',115,33],['charming',120,33],['kind',38,24],['inclusive',80,24]];
const DROP=(process.argv[2]||'').split(',');const WORDS=ALL.filter(w=>!DROP.includes(w[0]));const GAP=12;
function place(W,H,INSET){
  const items=WORDS.map(([k,w,h],i)=>({k,w,h,i})).sort((a,b)=>b.w*b.h-a.w*a.h);
  let seed=0; WORDS.forEach(([t])=>{for(let j=0;j<t.length;j++) seed=(seed*31+t.charCodeAt(j))|0;});
  const theta0=(Math.abs(seed)%628)/100, cx=W/2, cy=H/2, kx=Math.min(1,W/H), ky=Math.min(1,H/W);
  const placed=[]; let fallbacks={half:0,zero:0,edge:0,pile:0};
  const find=(it,gap,inset)=>{for(let s=0;s<3000;s++){const r=s*0.9,th=theta0+s*0.35;const tx=cx+r*Math.cos(th)*kx-it.w/2,ty=cy+r*Math.sin(th)*ky-it.h/2;if(tx<inset||ty<inset||tx+it.w>W-inset||ty+it.h>H-inset)continue;if(!placed.some(p=>tx<p.x+p.w+gap&&tx+it.w+gap>p.x&&ty<p.y+p.h+gap&&ty+it.h+gap>p.y))return [tx,ty];}return null;};
  for(const it of items){let s=find(it,GAP,INSET);if(!s){s=find(it,GAP/2,INSET);if(s)fallbacks.half++;}if(!s){s=find(it,0,INSET);if(s)fallbacks.zero++;}if(!s){s=find(it,0,0);if(s)fallbacks.edge++;}if(!s){s=[cx-it.w/2,cy-it.h/2];fallbacks.pile++;}placed.push({x:s[0],y:s[1],w:it.w,h:it.h});it.home=s;}
  const bodies=[];items.forEach(it=>bodies[it.i]=it);return {bodies,fallbacks};
}
function commit(bodies,idx,W,H,{frac,margin,inset,gap,vacancy}){
  const b=bodies[idx];const cX=(W-b.w)/2,cY=(H-b.h)/2;
  const tX=b.home[0]+(cX-b.home[0])*frac,tY=b.home[1]+(cY-b.home[1])*frac;
  const zone={x:tX-margin,y:tY-margin,w:b.w+2*margin,h:b.h+2*margin};
  const T=bodies.map(f=>[f.home[0],f.home[1]]);const n=bodies.length;const PG=bodies.map((A,i)=>bodies.map((C,j)=>{const sx=Math.max(A.home[0]-(C.home[0]+C.w),C.home[0]-(A.home[0]+A.w)),sy=Math.max(A.home[1]-(C.home[1]+C.h),C.home[1]-(A.home[1]+A.h));return Math.max(0,Math.min(gap,Math.max(sx,sy)));}));
  const inZone=(x,y,f)=>x<zone.x+zone.w&&x+f.w>zone.x&&y<zone.y+zone.h&&y+f.h>zone.y;
  const clamp=(i)=>{const f=bodies[i];const x0=Math.min(inset,f.home[0]),x1=Math.max(W-inset-f.w,f.home[0]),y0=Math.min(inset,f.home[1]),y1=Math.max(H-inset-f.h,f.home[1]);T[i][0]=Math.max(x0,Math.min(x1,T[i][0]));T[i][1]=Math.max(y0,Math.min(y1,T[i][1]));};
  for(let it=0;it<200;it++){const pull=it<120?0.04:0;
    for(let i=0;i<n;i++){if(i===idx)continue;const f=bodies[i];
      if(pull>0){T[i][0]+=(f.home[0]-T[i][0])*pull;T[i][1]+=(f.home[1]-T[i][1])*pull;}
      if(inZone(T[i][0],T[i][1],f)){let dx=T[i][0]+f.w/2-(zone.x+zone.w/2),dy=T[i][1]+f.h/2-(zone.y+zone.h/2);
        if(vacancy){ // bias the push toward the hole the chosen word left
          const vx=b.home[0]+b.w/2-(zone.x+zone.w/2),vy=b.home[1]+b.h/2-(zone.y+zone.h/2);const vl=Math.hypot(vx,vy)||1;dx+=vx/vl*vacancy*Math.hypot(dx,dy);dy+=vy/vl*vacancy*Math.hypot(dx,dy);}
        const d=Math.hypot(dx,dy)||1;T[i][0]+=dx/d*8;T[i][1]+=dy/d*8;}
      clamp(i);
      if(inZone(T[i][0],T[i][1],f)){T[i][1]+=(T[i][1]+f.h/2>=zone.y+zone.h/2?8:-8);}
    }
    for(let i=0;i<n;i++){if(i===idx)continue;for(let j=i+1;j<n;j++){if(j===idx)continue;const a=bodies[i],c=bodies[j];const g=PG[i][j];const ox=T[i][0]+a.w+g-T[j][0],oy=T[i][1]+a.h+g-T[j][1],oxn=T[j][0]+c.w+g-T[i][0],oyn=T[j][1]+c.h+g-T[i][1];
      if(ox>0&&oxn>0&&oy>0&&oyn>0){const mx=Math.min(ox,oxn),my=Math.min(oy,oyn);if(mx<my){const p=(ox<oxn?ox:-oxn)/2;T[i][0]-=p;T[j][0]+=p;}else{const p=(oy<oyn?oy:-oyn)/2;T[i][1]-=p;T[j][1]+=p;}}}}
    for(let i=0;i<n;i++){if(i!==idx)clamp(i);}
  }
  T[idx]=[tX,tY];
  // score: real overlaps (no gap) with >2px both axes; total displacement
  let bad=0,worst=0,moved=0;for(let i=0;i<n;i++){moved+=Math.hypot(T[i][0]-bodies[i].home[0],T[i][1]-bodies[i].home[1]);for(let j=i+1;j<n;j++){const a=bodies[i],c=bodies[j];const ox=Math.min(T[i][0]+a.w,T[j][0]+c.w)-Math.max(T[i][0],T[j][0]),oy=Math.min(T[i][1]+a.h,T[j][1]+c.h)-Math.max(T[i][1],T[j][1]);if(ox>2&&oy>2){bad++;worst=Math.max(worst,Math.min(ox,oy));}}}
  return {bad,worst,moved,travel:Math.hypot(tX-b.home[0],tY-b.home[1])};
}



const AREA=WORDS.reduce((a,[,w,h])=>a+(w+GAP)*(h+GAP),0);

console.log(WORDS.length,'words; dropped:',DROP.join(' ')||'—');
for(const k of [1.5,1.6,1.7,1.8,1.9,2.0]){let first=0,total=0,grown=0,edge=0,n=0,any=0;
 for(let W=288;W<=398;W+=1){let H=Math.max(300,Math.ceil(k*AREA/W));let p=place(W,H,16);let tries=0;while((p.fallbacks.pile||p.fallbacks.edge)&&tries<8){H+=20;p=place(W,H,16);tries++;}if(tries)grown++;if(p.fallbacks.pile||p.fallbacks.edge)edge++;n++;
  for(let i=0;i<p.bodies.length;i++){total++;const r=commit(p.bodies,i,W,H,{frac:1,margin:12,inset:16,gap:12,vacancy:0});if(!r.bad)first++;}}
 console.log('k='+k,'H at 370/358/343/328:',[370,358,343,328].map(W=>Math.max(300,Math.ceil(k*AREA/W))).join('/'),'| taps centring fully',Math.round(first/total*100)+'%','| widths that had to grow',grown+'/'+n,'| still unseated after growing',edge);}
