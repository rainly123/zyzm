!function(n){return"function"==typeof define?define(["jquery"],n):n($)}(function(n){var t,e;return n.notice=function(t,e,i){var o,a,r,l;return e instanceof Function&&(i=e),null==e&&(e=n("#container, .container")),e.length||(e=n("body")),o=n("#notice"),a=o.children(),l=function(){var e;return 0===o.length&&r(),e=n("<li class='note'><div class='note-content'>"+t+"</div></li>").appendTo(o),a.remove(),e.addClass("show"),setTimeout(function(){return e.removeClass("show").one("webkitTransitionEnd",function(){return n(this).remove(),i&&i()})},1800)},r=function(){return o=n('<ul id="notice"></ul>').appendTo(e)},l()},e=function(n){var t,e;return e=document.createElement("style"),e.appendChild(document.createTextNode(n)),t=document.querySelector("head").appendChild(e)},t="#notice{position:fixed;bottom:15%;width:100%;margin:0;padding:0;list-style:none;font-size:20px;-webkit-transition:all .4s;-moz-transition:all .4s;-o-transition:all .4s;transition:all .4s}#notice .note{position:absolute;width:100%;text-align:center;-webkit-transition:all .4s linear;-moz-transition:all .4s linear;-o-transition:all .4s linear;transition:all .4s linear;opacity:0}#notice .show{opacity:1}#notice .note-content{display:inline-block;padding:10px 15px;margin-bottom:20px;background:rgba(40,40,40,0.9);color:#fff;text-shadow:black 0 1px 2px;border:1px solid rgba(0,0,0,0.7);border-radius:6px;box-shadow:rgba(0,0,0,0.8) 0 0 20px;position:relative}",e(t)});