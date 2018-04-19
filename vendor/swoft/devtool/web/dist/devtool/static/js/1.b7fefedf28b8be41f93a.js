webpackJsonp([1],{"4oS3":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=o(i("iPXh")),n=i("EkEG"),a=i("6Kpo"),r=o(i("ZzWC"));function o(t){return t&&t.__esModule?t:{default:t}}e.default={name:"v-tab-item",mixins:[s.default,(0,a.inject)("tabs","v-tab-item","v-tabs-items")],components:{VTabTransition:n.VTabTransition,VTabReverseTransition:n.VTabReverseTransition},directives:{Touch:r.default},data:function(){return{isActive:!1,reverse:!1}},props:{id:String,transition:{type:[Boolean,String],default:"tab-transition"},reverseTransition:{type:[Boolean,String],default:"tab-reverse-transition"}},computed:{computedTransition:function(){return this.reverse?this.reverseTransition:this.transition}},methods:{toggle:function(t,e,i,s){this.$el.style.transition=i?null:"none",this.reverse=e,this.isActive=(this.id||s.toString())===t}},mounted:function(){this.tabs.register(this)},beforeDestroy:function(){this.tabs.unregister(this)},render:function(t){var e=t("div",{staticClass:"tabs__content",directives:[{name:"show",value:this.isActive}],domProps:{id:this.id},on:this.$listeners},this.showLazyContent(this.$slots.default));return this.computedTransition?t("transition",{props:{name:this.computedTransition}},[e]):e}}},"7sJU":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={methods:{newOffset:function(t){var e=this.$refs.wrapper.clientWidth;return"prev"===t?Math.max(this.scrollOffset-e,0):Math.min(this.scrollOffset+e,this.$refs.container.clientWidth-e)},onTouchStart:function(t){this.startX=this.scrollOffset+t.touchstartX,this.$refs.container.style.transition="none",this.$refs.container.style.willChange="transform"},onTouchMove:function(t){this.scrollOffset=this.startX-t.touchmoveX},onTouchEnd:function(){var t=this.$refs.container,e=this.$refs.wrapper,i=t.clientWidth-e.clientWidth;t.style.transition=null,t.style.willChange=null,this.scrollOffset<0||!this.isOverflowing?this.scrollOffset=0:this.scrollOffset>=i&&(this.scrollOffset=i)}}}},B8wM:function(t,e){},FELa:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s,n=i("6Kpo"),a=i("ZzWC"),r=(s=a)&&s.__esModule?s:{default:s};e.default={name:"v-tabs-items",mixins:[(0,n.provide)("tabs")],directives:{Touch:r.default},inject:{registerItems:{default:null},tabProxy:{default:null},unregisterItems:{default:null}},data:function(){return{items:[],lazyValue:this.value,reverse:!1}},props:{cycle:Boolean,touchless:Boolean,value:[Number,String]},computed:{activeIndex:function(){var t=this;return this.items.findIndex(function(e,i){return(e.id||i.toString())===t.lazyValue})},activeItem:function(){if(this.items.length)return this.items[this.activeIndex]},inputValue:{get:function(){return this.lazyValue},set:function(t){t=t.toString(),this.lazyValue=t,this.tabProxy?this.tabProxy(t):this.$emit("input",t)}}},watch:{activeIndex:function(t,e){this.reverse=t<e,this.updateItems()},value:function(t){this.lazyValue=t}},mounted:function(){this.registerItems&&this.registerItems(this.changeModel)},beforeDestroy:function(){this.unregisterItems&&this.unregisterItems()},methods:{changeModel:function(t){this.inputValue=t},next:function(t){var e=this.activeIndex+1;if(!this.items[e]){if(!t)return;e=0}this.inputValue=this.items[e].id||e},prev:function(t){var e=this.activeIndex-1;if(!this.items[e]){if(!t)return;e=this.items.length-1}this.inputValue=this.items[e].id||e},onSwipe:function(t){this[t](this.cycle)},register:function(t){this.items.push(t)},unregister:function(t){this.items=this.items.filter(function(e){return e!==t})},updateItems:function(){for(var t=this.items.length;--t>=0;)this.items[t].toggle(this.lazyValue,this.reverse,this.isBooted,t);this.isBooted=!0}},render:function(t){var e=this,i={staticClass:"tabs__items",directives:[]};return!this.touchless&&i.directives.push({name:"touch",value:{left:function(){return e.onSwipe("next")},right:function(){return e.onSwipe("prev")}}}),t("div",i,this.$slots.default)}}},FdFg:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=r(i("FELa")),n=r(i("RRL1")),a=r(i("MzNm"));function r(t){return t&&t.__esModule?t:{default:t}}e.default={methods:{genBar:function(t){return this.$createElement("div",{staticClass:"tabs__bar",class:this.addBackgroundColorClassChecks({"theme--dark":this.dark,"theme--light":this.light}),ref:"bar"},[this.genTransition("prev"),this.genWrapper(this.genContainer(t)),this.genTransition("next")])},genContainer:function(t){return this.$createElement("div",{staticClass:"tabs__container",class:{"tabs__container--align-with-title":this.alignWithTitle,"tabs__container--centered":this.centered,"tabs__container--fixed-tabs":this.fixedTabs,"tabs__container--grow":this.grow,"tabs__container--icons-and-text":this.iconsAndText,"tabs__container--overflow":this.isOverflowing,"tabs__container--right":this.right},style:this.containerStyles,ref:"container"},t)},genIcon:function(t){var e=this;return this.hasArrows&&this[t+"IconVisible"]?this.$createElement(a.default,{staticClass:"tabs__icon tabs__icon--"+t,props:{disabled:!this[t+"IconVisible"]},on:{click:function(){return e.scrollTo(t)}}},this[t+"Icon"]):null},genItems:function(t,e){return t.length>0?t:e.length?this.$createElement(s.default,e):null},genTransition:function(t){return this.$createElement("transition",{props:{name:"fade-transition"}},[this.genIcon(t)])},genWrapper:function(t){var e=this;return this.$createElement("div",{staticClass:"tabs__wrapper",class:{"tabs__wrapper--show-arrows":this.hasArrows},ref:"wrapper",directives:[{name:"touch",value:{start:function(t){return e.overflowCheck(t,e.onTouchStart)},move:function(t){return e.overflowCheck(t,e.onTouchMove)},end:function(t){return e.overflowCheck(t,e.onTouchEnd)}}}]},[t])},genSlider:function(t){return t.length||(t=[this.$createElement(n.default,{props:{color:this.sliderColor}})]),this.$createElement("div",{staticClass:"tabs__slider-wrapper",style:this.sliderStyles},t)}}}},Fe4h:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={watch:{activeTab:function(t,e){if(!e&&t&&this.updateTabs(),setTimeout(this.callSlider,0),t){var i=t.action;this.tabItems&&this.tabItems(i===t?this.tabs.indexOf(t).toString():i)}},alignWithTitle:"callSlider",centered:"callSlider",fixedTabs:"callSlider",hasArrows:function(t){t||(this.scrollOffset=0)},isBooted:"findActiveLink",lazyValue:"updateTabs",right:"callSlider",value:function(t){this.lazyValue=t},"$vuetify.application.left":"onResize","$vuetify.application.right":"onResize",scrollOffset:function(t){this.$refs.container.style.transform="translateX("+-t+"px)",this.hasArrows&&(this.prevIconVisible=this.checkPrevIcon(),this.nextIconVisible=this.checkNextIcon())}}}},IJwp:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={computed:{activeIndex:function(){var t=this;return this.tabs.findIndex(function(e,i){return(e.action===e?i.toString():e.action)===t.lazyValue})},activeTab:function(){if(this.tabs.length)return this.tabs[this.activeIndex]},containerStyles:function(){return this.height?{height:parseInt(this.height,10)+"px"}:null},hasArrows:function(){return(this.showArrows||!this.isMobile)&&this.isOverflowing},inputValue:{get:function(){return this.lazyValue},set:function(t){t=t.toString(),this.lazyValue=t,this.$emit("input",t)}},isMobile:function(){return this.$vuetify.breakpoint.width<this.mobileBreakPoint},sliderStyles:function(){return{left:this.sliderLeft+"px",transition:null!=this.sliderLeft?null:"none",width:this.sliderWidth+"px"}},target:function(){return this.activeTab?this.activeTab.action:null}}}},MnyQ:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),i("B8wM");var s=v(i("IJwp")),n=v(i("FdFg")),a=v(i("xmJw")),r=v(i("7sJU")),o=v(i("Fe4h")),l=v(i("Yn05")),c=v(i("vCdq")),u=v(i("jdFS")),h=i("6Kpo"),f=v(i("nfU3")),d=v(i("ZzWC"));function v(t){return t&&t.__esModule?t:{default:t}}e.default={name:"v-tabs",mixins:[(0,h.provide)("tabs"),l.default,c.default,s.default,a.default,n.default,r.default,o.default,u.default],directives:{Resize:f.default,Touch:d.default},provide:function(){return{tabClick:this.tabClick,tabProxy:this.tabProxy,registerItems:this.registerItems,unregisterItems:this.unregisterItems}},data:function(){return{bar:[],content:[],isBooted:!1,isOverflowing:!1,lazyValue:this.value,nextIconVisible:!1,prevIconVisible:!1,resizeTimeout:null,reverse:!1,scrollOffset:0,sliderWidth:null,sliderLeft:null,startX:0,tabsContainer:null,tabs:[],tabItems:null,transitionTime:300}},watch:{tabs:"onResize"},mounted:function(){this.checkIcons()},methods:{checkIcons:function(){this.prevIconVisible=this.checkPrevIcon(),this.nextIconVisible=this.checkNextIcon()},checkPrevIcon:function(){return this.scrollOffset>0},checkNextIcon:function(){var t=this.$refs.container,e=this.$refs.wrapper;return t.clientWidth>this.scrollOffset+e.clientWidth},callSlider:function(){var t=this;if(this.setOverflow(),this.hideSlider||!this.activeTab)return!1;var e=(this.activeTab||{}).action,i=e===this.activeTab?this.activeTab:this.tabs.find(function(t){return t.action===e});this.$nextTick(function(){i&&i.$el&&(t.sliderWidth=i.$el.scrollWidth,t.sliderLeft=i.$el.offsetLeft)})},onResize:function(){var t=this;this._isDestroyed||(clearTimeout(this.resizeTimeout),this.resizeTimeout=setTimeout(function(){t.callSlider(),t.checkIcons(),t.scrollIntoView()},this.transitionTime))},overflowCheck:function(t,e){this.isOverflowing&&e(t)},scrollTo:function(t){this.scrollOffset=this.newOffset(t)},setOverflow:function(){this.isOverflowing=this.$refs.bar.clientWidth<this.$refs.container.clientWidth},findActiveLink:function(){var t=this;if(this.tabs.length&&!this.lazyValue){var e=this.tabs.findIndex(function(e,i){return(e.action===e?i.toString():e.action)===t.lazyValue||e.$el.firstChild.className.indexOf(t.activeClass)>-1}),i=e>-1?e:0,s=this.tabs[i];this.inputValue=s.action===s?i:s.action}},parseNodes:function(){for(var t=[],e=[],i=[],s=[],n=(this.$slots.default||[]).length,a=0;a<n;a++){var r=this.$slots.default[a];if(r.componentOptions)switch(r.componentOptions.Ctor.options.name){case"v-tabs-slider":i.push(r);break;case"v-tabs-items":e.push(r);break;case"v-tab-item":t.push(r);break;default:s.push(r)}else s.push(r)}return{tab:s,slider:i,items:e,item:t}},register:function(t){this.tabs.push(t)},scrollIntoView:function(){if(!this.activeTab)return!1;var t=this.activeTab.$el,e=t.clientWidth,i=t.offsetLeft,s=this.$refs.wrapper.clientWidth+this.scrollOffset,n=e+i,a=.3*e;i<this.scrollOffset?this.scrollOffset=Math.max(i-a,0):s<n&&(this.scrollOffset-=s-n-a)},tabClick:function(t){this.inputValue=t.action===t?this.tabs.indexOf(t):t.action,this.scrollIntoView()},tabProxy:function(t){this.lazyValue=t},registerItems:function(t){this.tabItems=t},unregisterItems:function(){this.tabItems=null},unregister:function(t){this.tabs=this.tabs.filter(function(e){return e!==t})},updateTabs:function(){for(var t=this.tabs.length;--t>=0;)this.tabs[t].toggle(this.target);this.setOverflow()}},render:function(t){var e=this.parseNodes(),i=e.tab,s=e.slider,n=e.items,a=e.item;return t("div",{staticClass:"tabs",directives:[{name:"resize",arg:400,modifiers:{quiet:!0},value:this.onResize}]},[this.genBar([this.hideSlider?null:this.genSlider(s),i]),this.genItems(n,a)])}}},"N+yG":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s,n=i("aoP+"),a=(s=n)&&s.__esModule?s:{default:s},r=i("6Kpo"),o=i("L8WB");e.default={name:"v-tab",mixins:[(0,r.inject)("tabs","v-tab","v-tabs"),a.default],inject:["tabClick"],data:function(){return{isActive:!1}},props:{activeClass:{type:String,default:"tabs__item--active"},ripple:{type:[Boolean,Object],default:!0}},computed:{classes:function(){return t={tabs__item:!0,"tabs__item--disabled":this.disabled},e=this.activeClass,i=!this.to&&this.isActive,e in t?Object.defineProperty(t,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[e]=i,t;var t,e,i},action:function(){var t=this.to||this.href;this.$router&&this.to===Object(this.to)&&(t=this.$router.resolve(this.to,this.$route,this.append).href);return"string"==typeof t?t.replace("#",""):this}},watch:{$route:"onRouteChange"},mounted:function(){this.tabs.register(this),this.onRouteChange()},beforeDestroy:function(){this.tabs.unregister(this)},methods:{click:function(t){this.href&&this.href.indexOf("#")>-1&&t.preventDefault(),this.$emit("click",t),this.to||this.tabClick(this)},onRouteChange:function(){var t=this;if(this.to&&this.$refs.link){var e="_vnode.data.class."+this.activeClass;this.$nextTick(function(){(0,o.getObjectValueByPath)(t.$refs.link,e)&&t.tabClick(t)})}},toggle:function(t){this.isActive=t===this||t===this.action}},render:function(t){var e=this.generateRouteLink(),i=e.data,s=this.disabled?"div":e.tag;return i.ref="link",t("div",{staticClass:"tabs__div"},[t(s,i,this.$slots.default)])}}},RRL1:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s,n=i("Yn05"),a=(s=n)&&s.__esModule?s:{default:s};e.default={name:"v-tabs-slider",mixins:[a.default],data:function(){return{defaultColor:"accent"}},render:function(t){return t("div",{staticClass:"tabs__slider",class:this.addBackgroundColorClassChecks()})}}},W7O9:function(t,e){},bT5T:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=i("4YfN"),n=i.n(s),a=i("W4j8"),r=i.n(a),o=i("uaVa"),l=i.n(o),c=i("KatZ"),u=i("mlLv"),h=i("ZXMi");var f={name:"httpRoutes",components:n()({VAlert:r.a},c,u,{VDataTable:l.a}),data:function(){return{stSearch:"",rgSearch:"",rawData:[],pageOpts:[10,25,{text:"All",value:-1}],stHeaders:[{text:"Uri Path",align:"left",sortable:!1,value:"path"},{text:"Method",align:"left",value:"method"},{text:"Route Handler",align:"left",value:"handler"}],rgHeaders:[{text:"Uri Pattern",sortable:!1,value:"original"},{text:"Allowed Methods",value:"methods"},{text:"Route Handler",value:"handler"}],staticList:[],cacheList:[],regularList:[],vagueList:[]}},created:function(){this.fetchList()},mounted:function(){},computed:{},methods:{fetchList:function(){var t=this;Object(h.j)().then(function(e){var i=e.data;console.log(i),t.rawData=i,function(t,e){for(var i in t){var s=t[i];for(var n in s){var a={path:i};a.method=n,a.handler=s[n].handler,e.staticList.push(a)}}}(i.static,t),function(t,e){for(var i in t){var s=t[i];for(var n in s){var a=s[n].methods;e.regularList.push({first:i,methods:a.substr(0,a.length-1),regex:s[n].regex,original:s[n].original,handler:s[n].handler,option:s[n].option})}}}(i.regular,t),t.cacheList=i.cached,t.vagueList=i.vague})}}},d={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"mb-2"},[i("v-subheader",[i("h1",[t._v(t._s(this.$route.name))])]),t._v(" "),i("v-tabs",{attrs:{color:"blue lighten-5"}},[i("v-tabs-slider",{attrs:{color:"blue"}}),t._v(" "),i("v-tab",{attrs:{href:"#tab-1"}},[i("strong",[t._v("Static Routes")])]),t._v(" "),i("v-tab",{attrs:{href:"#tab-2"}},[i("strong",[t._v("Dynamic Routes(Regular)")])]),t._v(" "),i("v-tab-item",{attrs:{id:"tab-1"}},[i("v-card",[i("v-card-title",{staticClass:"pt-1"},[i("v-spacer"),t._v(" "),i("v-text-field",{attrs:{"append-icon":"search",label:"Search","single-line":"","hide-details":""},model:{value:t.stSearch,callback:function(e){t.stSearch=e},expression:"stSearch"}})],1),t._v(" "),i("v-divider"),t._v(" "),i("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.stHeaders,items:t.staticList,search:t.stSearch,"rows-per-page-items":t.pageOpts,"disable-initial-sort":""},scopedSlots:t._u([{key:"items",fn:function(e){return[i("td",[t._v(t._s(e.item.path))]),t._v(" "),i("td",[t._v(t._s(e.item.method))]),t._v(" "),i("td",[i("code",[t._v(t._s(e.item.handler))])])]}}])},[i("template",{slot:"no-data"},[i("v-alert",{attrs:{value:!0,color:"info",icon:"info"}},[t._v("\n              Sorry, nothing to display here :(\n            ")])],1),t._v(" "),i("template",{slot:"footer"},[i("td",{attrs:{colspan:"100%"}},[i("strong",[t._v("This is an extra footer")])])]),t._v(" "),i("v-alert",{attrs:{slot:"no-results",value:!0,color:"error",icon:"warning"},slot:"no-results"},[t._v('\n            Your search for "'+t._s(t.stSearch)+'" found no results.\n          ')])],2)],1)],1),t._v(" "),i("v-tab-item",{attrs:{id:"tab-2"}},[i("v-card",[i("v-card-title",{staticClass:"pt-1"},[i("v-spacer"),t._v(" "),i("v-text-field",{attrs:{"append-icon":"search",label:"Search","single-line":"","hide-details":""},model:{value:t.rgSearch,callback:function(e){t.rgSearch=e},expression:"rgSearch"}})],1),t._v(" "),i("v-divider"),t._v(" "),i("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.rgHeaders,items:t.regularList,search:t.rgSearch,"rows-per-page-items":t.pageOpts,"disable-initial-sort":""},scopedSlots:t._u([{key:"items",fn:function(e){return[i("td",[t._v(t._s(e.item.original))]),t._v(" "),i("td",[t._v(t._s(e.item.methods))]),t._v(" "),i("td",[i("code",[t._v(t._s(e.item.handler))])])]}}])},[i("template",{slot:"no-data"},[i("v-alert",{attrs:{value:!0,color:"info",icon:"info"}},[t._v("\n              Sorry, nothing to display here :(\n            ")])],1),t._v(" "),i("template",{slot:"footer"},[i("td",{attrs:{colspan:"100%"}},[i("strong",[t._v("This is an extra footer")])])]),t._v(" "),i("v-alert",{attrs:{slot:"no-results",value:!0,color:"error",icon:"warning"},slot:"no-results"},[t._v('\n            Your search for "'+t._s(t.stSearch)+'" found no results.\n          ')])],2)],1)],1)],1)],1)},staticRenderFns:[]};var v=i("Z0/y")(f,d,!1,function(t){i("W7O9")},"data-v-3e938b07",null);e.default=v.exports},mlLv:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.VTabsSlider=e.VTabsItems=e.VTab=e.VTabItem=e.VTabs=void 0;var s=l(i("MnyQ")),n=l(i("N+yG")),a=l(i("FELa")),r=l(i("4oS3")),o=l(i("RRL1"));function l(t){return t&&t.__esModule?t:{default:t}}e.VTabs=s.default,e.VTabItem=r.default,e.VTab=n.default,e.VTabsItems=a.default,e.VTabsSlider=o.default,s.default.install=function(t){t.component(s.default.name,s.default),t.component(n.default.name,n.default),t.component(a.default.name,a.default),t.component(r.default.name,r.default),t.component(o.default.name,o.default)},e.default=s.default},xmJw:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{alignWithTitle:Boolean,centered:Boolean,fixedTabs:Boolean,grow:Boolean,height:{type:[Number,String],default:void 0,validator:function(t){return!isNaN(parseInt(t))}},hideSlider:Boolean,iconsAndText:Boolean,mobileBreakPoint:{type:[Number,String],default:1264,validator:function(t){return!isNaN(parseInt(t))}},nextIcon:{type:String,default:"chevron_right"},prevIcon:{type:String,default:"chevron_left"},right:Boolean,showArrows:Boolean,sliderColor:{type:String,default:"accent"},value:[Number,String]}}}});
//# sourceMappingURL=1.b7fefedf28b8be41f93a.js.map