import{w as g,d as m,e as p}from"./runtime-dom.esm-bundler-96a1b9d2.js";import{d as T}from"./index-73543de1.js";import{D as V,B as j,j as y,l as S,o as d,c as r,d as s,t as n,u as i,f as b,k as u,F as f,E as h,v as U}from"./index-6dfe74f8.js";const M={class:"w-2/5 h-full overflow-y-scroll"},B={class:"my-3 p-4 bg-white"},D={key:0,class:"block mx-4"},$=s("div",{class:"text-white bg-blue-500 border-0 py-2 px-4 my-3 focus:outline-none hover:bg-blue-600 rounded"},"編集する",-1),C=[$],E={class:"my-3 text-2xl font-bold"},N=s("hr",null,null,-1),O={class:"flex"},A=U('<div class="w-1/2"><div class="my-4">優先度：</div><div class="my-4">状態：</div><div class="my-4">開始日：</div><div class="my-4">終了日：</div></div>',1),F={class:"w-1/2"},R={class:"my-4"},q={class:"my-4"},z={class:"my-4"},I={class:"my-4"},L=s("p",{class:"mt-5 mb-2"},"目的",-1),P={class:"h-20 mb-5 border-2 overflow-y-scroll break-words"},G=s("hr",null,null,-1),H={class:"my-4"},J=s("p",{class:"w-1/4 mb-2"},"メモ",-1),K={class:"h-80 mx-auto border-2 overflow-y-scroll break-words"},Q={key:1,class:"mx-4"},W=s("div",{class:"text-white bg-blue-500 border-0 py-2 px-4 my-3 focus:outline-none hover:bg-blue-600 rounded"},"詳細を見る",-1),X=[W],Y={class:"border-b-2"},Z={class:"my-4"},ss=s("label",null,"優先度：",-1),ts=s("option",{value:""},null,-1),es={class:"my-4"},os=s("label",{class:"ml-2"},"状態：",-1),ls={class:"my-4"},as=s("label",null,"開始日：",-1),is={class:"my-4"},ns=s("label",null,"終了日：",-1),ds=s("p",{class:"mt-5 mb-1"},"目的",-1),rs=s("hr",null,null,-1),us=s("p",{class:"mt-5 mb-1"},"メモ",-1),_s=s("div",{class:"flex justify-center"},[s("button",{class:"inline-flex text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded"},"更新")],-1),cs={__name:"ShowMainTask",props:{mainTask:Object,statuses:Array,priorityRanks:Array},emits:["update"],setup(k,{emit:x}){const a=k,{mainTask:o}=V(a),t=j({id:o.value.id,title:o.value.title,priority_rank:o.value.priority_rank,purpose:o.value.purpose,status:o.value.status,start_day:o.value.start_day,finish_day:o.value.finish_day,memo:o.value.memo}),_=y(!0),c=y(!1);S(o,()=>{t.id=a.mainTask.id,t.title=a.mainTask.title,t.priority_rank=a.mainTask.priority_rank,t.purpose=a.mainTask.purpose,t.status=a.mainTask.status,t.start_day=a.mainTask.start_day,t.finish_day=a.mainTask.finish_day,t.comment=a.mainTask.comment,_.value=!0,c.value=!1});const w=v=>{T.Inertia.put(`/mainTask/${v}`,t),c.value=!1,_.value=!0,x("update",t)};return(v,l)=>(d(),r("div",M,[s("div",B,[_.value&&!c.value?(d(),r("div",D,[s("div",{class:"flex justify-end",onClick:l[0]||(l[0]=e=>{c.value=!0,_.value=!1})},C),s("h3",E,n(i(o).title),1),N,s("div",O,[A,s("div",F,[s("div",R,n(i(o).priority_rank?i(o).priority_rank:"　"),1),s("div",q,n(i(o).status?i(o).status:"　"),1),s("div",z,n(i(o).start_day?i(o).start_day:"　"),1),s("div",I,n(i(o).finish_day?i(o).finish_day:"　"),1)])]),L,s("div",P,n(i(o).purpose),1),G,s("div",H,[J,s("div",K,n(i(o).memo),1)])])):b("",!0),c.value&&!_.value?(d(),r("div",Q,[s("div",{class:"flex justify-end",onClick:l[1]||(l[1]=e=>{c.value=!1,_.value=!0})},X),s("form",{onSubmit:l[9]||(l[9]=g(e=>{w(t.id)},["prevent"]))},[s("div",Y,[u(s("input",{type:"text",class:"w-full text-2xl font-bold border-0 focus:ring-0","onUpdate:modelValue":l[2]||(l[2]=e=>t.title=e),required:""},null,512),[[m,t.title]])]),s("div",Z,[ss,u(s("select",{class:"border-2 ml-1","onUpdate:modelValue":l[3]||(l[3]=e=>t.priority_rank=e)},[ts,(d(!0),r(f,null,h(a.priorityRanks,e=>(d(),r("option",{key:e},n(e),1))),128))],512),[[p,t.priority_rank]])]),s("div",es,[os,u(s("select",{class:"border-2 ml-1","onUpdate:modelValue":l[4]||(l[4]=e=>t.status=e)},[(d(!0),r(f,null,h(a.statuses,e=>(d(),r("option",{key:e},n(e),1))),128))],512),[[p,t.status]])]),s("div",ls,[as,u(s("input",{type:"date",class:"border-2 ml-1","onUpdate:modelValue":l[5]||(l[5]=e=>t.start_day=e)},null,512),[[m,t.start_day]])]),s("div",is,[ns,u(s("input",{type:"date",class:"border-2 ml-1","onUpdate:modelValue":l[6]||(l[6]=e=>t.finish_day=e)},null,512),[[m,t.finish_day]])]),ds,u(s("textarea",{class:"w-full mb-5 border-2","onUpdate:modelValue":l[7]||(l[7]=e=>t.purpose=e),placeholder:"目的を書く",cols:"42",rows:"4"},null,512),[[m,t.purpose]]),rs,us,u(s("textarea",{class:"w-full mb-5 border-2","onUpdate:modelValue":l[8]||(l[8]=e=>t.memo=e),placeholder:"メモを書く",cols:"42",rows:"10"},null,512),[[m,t.memo]]),_s],32)])):b("",!0)])]))}},ys=Object.freeze(Object.defineProperty({__proto__:null,default:cs},Symbol.toStringTag,{value:"Module"}));export{ys as _,cs as a};
