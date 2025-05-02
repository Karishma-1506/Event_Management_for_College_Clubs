window.addEventListener('DOMContentLoaded',()=>{
  const dates=window.eventDates||[];
  const cal=document.getElementById('calendar');
  const today=new Date(),y=today.getFullYear(),m=today.getMonth();
  const days=new Date(y,m+1,0).getDate();
  const fd=new Date(y,m,1).getDay();
  let html='<table><tr>'+['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].map(d=>`<th>${d}</th>`).join('')+'</tr><tr>';
  for(let i=0;i<fd;i++)html+='<td></td>';
  for(let d=1;d<=days;d++){const iso=`${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`,c=dates.includes(iso)?' class="red-dot"':'';html+=`<td${c}>${d}</td>`;if((fd+d)%7===0)html+='</tr><tr>';}html+='</tr></table>';
  cal.innerHTML=html;
});