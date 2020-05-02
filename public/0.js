(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{185:function(e,t,n){"use strict";n.r(t);var r=n(53),i=n(3),o=n(5),s=n(8),a=n(4),c=n(1);function u(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function l(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}var d={components:{IconEmail:r.a,Page:i.a,PageHeader:a.a,PageBlock:o.a,BigButton:s.a},created:function(){var e=this;this.loggedIn&&!this.needVerification&&this.$router.push({name:"dashboard"}),this.$route.params.user&&this.$route.params.hash&&(this.$store.dispatch("errors/clear"),this.$store.dispatch("auth/verifyEmail",{user:this.$route.params.user,hash:this.$route.params.hash}).then((function(){e.errorsHappened||(e.loggedIn&&e.$store.dispatch("auth/fetch"),setTimeout((function(){e.$router.push({name:"dashboard"})}),1e4))})))},methods:{resend:function(){this.$store.dispatch("errors/clear"),this.$store.dispatch("auth/resendVerification")}},computed:function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?u(Object(n),!0).forEach((function(t){l(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):u(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}({},Object(c.b)("loading",["disable"]),{},Object(c.b)("auth",["loggedIn","needVerification"]),{},Object(c.b)("errors",{errorsHappened:"happened",hasError:"has"}),{},Object(c.c)("errors",{errors:function(e){return e.errors}}),{},Object(c.c)("message",{message:function(e){return e.message}}),{},Object(c.c)("auth",{user:function(e){return e.user}}))},p=n(0),f=n(94),h=n(95),g=Object(p.a)(d,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("Page",{scopedSlots:e._u([{key:"bottom",fn:function(){return[e.errorsHappened?n("PageBlock",e._l(e.errors,(function(t,r){return n("div",{staticClass:"text-prime-500",domProps:{innerHTML:e._s(e.$t("errors."+r))}})})),0):e._e(),e._v(" "),e.errorsHappened?e._e():n("PageBlock",[e._v("\n        "+e._s(e.$t("messages.checkEmail"))+"\n        "),n("p",[e._v(e._s(e.$t("messages.canResend")))])]),e._v(" "),e.loggedIn?n("BigButton",{attrs:{disable:e.disable},on:{clicked:e.resend}},[e._v("\n        "+e._s(e.$t("button"))+"\n      ")]):e._e(),e._v(" "),e.loggedIn?e._e():n("PageBlock",[e._v("\n        "+e._s(e.$t("messages.loginToSend"))+"\n      ")]),e._v(" "),e.loggedIn?e._e():n("BigButton",{on:{clicked:function(t){return e.$router.push({name:"login"})}}},[e._v("\n        "+e._s(e.$t("login"))+"\n      ")])]},proxy:!0}])},[n("PageHeader",[e._v("\n        "+e._s(e.$t("pageTitle"))+"\n    ")]),e._v(" "),n("div",{staticClass:"page-icon"},[n("IconEmail",{attrs:{classes:"mx-auto",height:"75"}})],1)],1)}),[],!1,null,null,null);"function"==typeof f.default&&Object(f.default)(g),"function"==typeof h.default&&Object(h.default)(g);t.default=g.exports},22:function(e,t){e.exports=function(e){e.options.__i18n=e.options.__i18n||[],e.options.__i18n.push('{"ru":{"pageTitle":"Подтверждение электронной почты","button":"Отправить еще раз","login":"Вход","messages":{"checkEmail":"Проверьте свою почту, мы уже отправили ссылку для подтверждения адреса.","canResend":"Если письмо не нашлось, то ссылку для подтверждения можно отправить повторно.","newLinkSent":"Ссылка для подтверждения электронной почты отправлена на адрес, указанный при регистрации.","alreadyVerified":"Вы подтвердили свою почту раньше. Теперь вы можете пользоваться программой.","verified":"Ваша почта подтверждена! Теперь вы можете пользоваться программой.","loginToSend":"Войдите, чтобы оптправить повторное проверочное письмо."},"errors":{"verification":"Не удалось подтвердить почту. Попробуйте позже.","connection":"Не удалось отправить письмо для продтверждения","verify":"Это некорректная ссылка для подтверждения почты. Используйте ссылку из письма, которое вам пришло на адрес, указанный при регистрации. <p>Вы можете отправить новое письмо со ссылкой для подтверждения.</p>"}}}'),delete e.options._Ctor}},23:function(e,t){e.exports=function(e){e.options.__i18n=e.options.__i18n||[],e.options.__i18n.push('{"en":{"pageTitle":"Email verification","button":"Send again","login":"Sign in","messages":{"checkEmail":"Check your mailbox, we sent you a verification email.","canResend":"If you don\'t get a mail, you can resend it with button below.","newLinkSent":"We sent a new verification link to email provided while register","alreadyVerified":"Your email is already verified. Enjoy!","verified":"Your email now is verified! Enjoy.","loginToSend":"You need to sign in to resend verification email."},"errors":{"verification":"We can\'t verify your email right now. Please try again later.","connection":"Can\'t send a verification email right now. Please try later","verify":"You tried to use incorrect link. Please use a link from email you entered in registration form. <p>You can send a new mail with verification link.</p>"}}}'),delete e.options._Ctor}},53:function(e,t,n){"use strict";var r={props:["height","classes"]},i=n(0),o=Object(i.a)(r,(function(){var e=this.$createElement,t=this._self._c||e;return t("svg",{staticClass:"fill-current",class:this.classes,attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",height:this.height}},[t("path",{attrs:{d:"M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"}})])}),[],!1,null,null,null);t.a=o.exports},94:function(e,t,n){"use strict";var r=n(22),i=n.n(r);t.default=i.a},95:function(e,t,n){"use strict";var r=n(23),i=n.n(r);t.default=i.a}}]);