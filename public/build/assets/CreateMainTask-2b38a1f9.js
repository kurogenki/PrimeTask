import{w as v,b as a,d as p}from"./runtime-dom.esm-bundler-581872e9.js";import{d as x}from"./index-f9f048a8.js";import{B as b,o as n,e as i,b as t,k as l,t as u,f as h,d,F as _,E as m}from"./index-3dcbba6c.js";const k={class:"w-2/5 h-screen-minus-14 overflow-y-scroll"},w={class:"my-3 p-4 bg-white"},V=t("div",{class:"text-3xl font-extrabold"},"メインタスクの作成",-1),g=["onSubmit"],j={class:"w-11/12 mx-auto my-3"},A=t("p",{class:"font-semibold"},"タイトル",-1),M={class:"flex justify-center"},T={key:0},U={class:"my-3"},S=t("option",{value:""},null,-1),B={class:"my-3"},O=t("option",{value:""},null,-1),R={class:"my-3"},C={class:"my-3"},N={class:"flex justify-center"},D=t("p",{class:"w-12"},"目的",-1),E={class:"w-11/12 my-3 mx-auto"},F=t("p",null,"メモ",-1),z={class:"flex justify-center"},I=t("div",{class:"flex justify-center my-2"},[t("button",{class:"inline-flex text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded"},"保存")],-1),L={__name:"CreateMainTask",props:{user:Object,statuses:Array,priorityRanks:Array,errors:Object},emits:["create"],setup(c,{emit:y}){const r=c,s=b({id:r.user.id,title:null,priorityRank:null,purpose:null,status:null,startAt:null,finishAt:null,memo:null}),f=()=>{x.Inertia.post("/mainTask",s),y("create")};return(P,o)=>(n(),i("div",k,[t("div",w,[V,t("form",{onSubmit:v(f,["prevent"])},[t("div",j,[A,t("div",M,[l(t("textarea",{type:"text",class:"w-4/5 h-28 mx-auto font-semibold border-2","onUpdate:modelValue":o[0]||(o[0]=e=>s.title=e)},null,512),[[a,s.title]])])]),r.errors.title?(n(),i("div",T,u(r.errors.title),1)):h("",!0),t("div",U,[d(" 優先度："),l(t("select",{"onUpdate:modelValue":o[1]||(o[1]=e=>s.priorityRank=e)},[S,(n(!0),i(_,null,m(r.priorityRanks,e=>(n(),i("option",{key:e},u(e),1))),128))],512),[[p,s.priorityRank]])]),t("div",B,[d(" 状態："),l(t("select",{"onUpdate:modelValue":o[2]||(o[2]=e=>s.status=e)},[O,(n(!0),i(_,null,m(r.statuses,e=>(n(),i("option",{key:e},u(e),1))),128))],512),[[p,s.status]])]),t("div",R,[d(" 開始日："),l(t("input",{type:"date","onUpdate:modelValue":o[3]||(o[3]=e=>s.startAt=e)},null,512),[[a,s.startAt]])]),t("div",C,[d(" 終了日："),l(t("input",{type:"date","onUpdate:modelValue":o[4]||(o[4]=e=>s.finishAt=e)},null,512),[[a,s.finishAt]])]),t("div",N,[D,l(t("textarea",{type:"text","onUpdate:modelValue":o[5]||(o[5]=e=>s.purpose=e)},null,512),[[a,s.purpose]])]),t("div",E,[F,t("div",z,[l(t("textarea",{type:"text",class:"h-64 border-2","onUpdate:modelValue":o[6]||(o[6]=e=>s.memo=e)},null,512),[[a,s.memo]])])]),I],40,g)])]))}},J=Object.freeze(Object.defineProperty({__proto__:null,default:L},Symbol.toStringTag,{value:"Module"}));export{J as _,L as a};
