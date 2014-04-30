<!-- footer starts -->
<!-- iE fix0002 starts--><div class="footer">
		<footer>
				<div class="footer-copy">&copy; 2013 Vocus Social Media, LLC</div>
				<!-- footer nav starts-->
				<ul>
				    <li><a  href="#/p/support">Support</a></li>
				    <li><a  href="#/p/analytics/overview">Analytics</a></li>
				    <li><a  href="#/p/services/overview">Services</a></li>
				    <li><a  href="#/p/about">About</a></li>
				    <li><a  href="#/p/north-contact">North Contact</a></li>
				    <li><a  href="//thenorthblog.com/" target="_blank">The North Blog</a></li>
				    <li><a  href="#/p/terms">Terms &amp; Privacy Policy</a></li>
				</ul>
				<!-- footer nav ends-->
		</footer>
</div><!-- iE fix0002 ends-->
<!-- footer ends -->


<script type="text/javascript">
    adroll_adv_id = "VY4HQ7S5IRCTBAUTQ3PCKT";
    adroll_pix_id = "ZLFIBO6PW5BW3HO63RL6A4";
    (function () {
        var oldonload = window.onload;
        window.onload = function() {
            __adroll_loaded = true;
            var scr = document.createElement("script");
            var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
            scr.setAttribute('async', 'true');
            scr.type = "text/javascript";
            scr.src = host + "/j/roundtrip.js";
            document.documentElement.firstChild.appendChild(scr);
            if (oldonload) {
                oldonload()
            }
        };
    }());

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-11435633-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

    //begin olark code
    /*{literal}<![CDATA[*/
    window.olark || (function(i) {
        var e = window,h = document,a = e.location.protocol == "https:" ? "https:" : "http:",g = i.name,b = "load";
        (function() {
            e[g] = function() {
                (c.s = c.s || []).push(arguments)
            };
            var c = e[g]._ = {},f = i.methods.length;
            while (f--) {
                (function(j) {
                    e[g][j] = function() {
                        e[g]("call", j, arguments)
                    }
                })(i.methods[f])
            }
            c.l = i.loader;
            c.i = arguments.callee;
            c.f = setTimeout(function() {
                if (c.f) {
                    (new Image).src = a + "//" + c.l.replace(".js", ".png") + "&" + escape(e.location.href)
                }
                c.f = null
            }, 20000);
            c.p = {0:+new Date};
            c.P = function(j) {
                c.p[j] = new Date - c.p[0]
            };
            function d() {
                c.P(b);
                e[g](b)
            }

            e.addEventListener ? e.addEventListener(b, d, false) : e.attachEvent("on" + b, d);
            (function() {
                function l(j) {
                    j = "head";
                    return["<",j,"></",j,"><",z,' onl' + 'oad="var d=',B,";d.getElementsByTagName('head')[0].",y,"(d.",A,"('script')).",u,"='",a,"//",c.l,"'",'"',"></",z,">"].join("")
                }

                var z = "body",s = h[z];
                if (!s) {
                    return setTimeout(arguments.callee, 100)
                }
                c.P(1);
                var y = "appendChild",A = "createElement",u = "src",r = h[A]("div"),G = r[y](h[A](g)),D = h[A]("iframe"),B = "document",C = "domain",q;
                r.style.display = "none";
                s.insertBefore(r, s.firstChild).id = g;
                D.frameBorder = "0";
                D.id = g + "-loader";
                if (/MSIE[ ]+6/.test(navigator.userAgent)) {
                    D.src = "javascript:false"
                }
                D.allowTransparency = "true";
                G[y](D);
                try {
                    D.contentWindow[B].open()
                } catch(F) {
                    i[C] = h[C];
                    q = "javascript:var d=" + B + ".open();d.domain='" + h.domain + "';";
                    D[u] = q + "void(0);"
                }
                try {
                    var H = D.contentWindow[B];
                    H.write(l());
                    H.close()
                } catch(E) {
                    D[u] = q + 'd.write("' + l().replace(/"/g, String.fromCharCode(92) + '"') + '");d.close();'
                }
                c.P(2)
            })()
        })()
    })({loader:(function(a) {
            return "static.olark.com/jsclient/loader0.js?ts=" + (a ? a[1] : (+new Date))
        })(document.cookie.match(/olarkld=([0-9]+)/)),name:"olark",methods:["configure","extend","declare","identify"]});
    /* custom configuration goes here (www.olark.com/documentation) */
    olark.identify('3152-352-10-1172');
    /*]]>{/literal}*/
    //end olark code
</script>