<div class="footer-clean">
    <footer>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 item">
                    <h3>@lang('main.produs')</h3>
                    <ul>
                        <li><a href="/{{session('locale')}}/category/calculatoare">@lang('main.pc')</a></li>
                        <li><a href="/{{session('locale')}}/category/monitor">@lang('main.monitor')</a></li>
                        <li><a href="/{{session('locale')}}/category/laptop">@lang('main.nb')</a></li>
                        <li><a href="/{{session('locale')}}/category/imprimante_mfu">@lang('main.printss')</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 item">
                    <h3>@lang('main.serv')</h3>
                    <ul>
                        <li><a href="{{route('locale.reparatii', session('locale'))}}" title="@lang('homebanner.b1_title')">@lang('homebanner.b1_title')</a></li>
                        <li><a href="{{route('locale.reparatie_laptop', session('locale'))}}" title="@lang('homebanner.b2_title')">@lang('homebanner.b2_title')</a></li>
                        <li><a href="{{route('locale.reincarcare', session('locale'))}}" title="@lang('homebanner.b3_title')">@lang('homebanner.b3_title')</a></li>
                        <li><a href="{{route('locale.hosting', session('locale'))}}" alt="@lang('main.hosting')">@lang('main.hosting')</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 item">
                    <h3>@lang('main.about')</h3>
                    <ul>
                        <li><a href="{{route('locale.contacte', session('locale'))}}" title="@lang('main.contact')">@lang('main.contact')</a></li>
                        <li><a href="{{route('locale.retur', session('locale'))}}" title="@lang('main.retur')">@lang('main.retur')</a></li>
                        <li><a href="{{route('locale.rechizite_bancare', session('locale'))}}" title="@lang('main.rechizite')">@lang('main.rechizite')</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 item"><a href="https://www.facebook.com/compmd1" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                        </svg></a>
                    <!--LiveInternet counter--><a href="https://www.liveinternet.ru/click"
                                                  target="_blank"><img id="licnt24B3" width="1" height="1" style="border:0"
                                                                       title="LiveInternet"
                                                                       src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAIBTAA7"
                                                                       alt=""/></a><script>(function(d,s){d.getElementById("licnt24B3").src=
                            "https://counter.yadro.ru/hit?t44.4;r"+escape(d.referrer)+
                            ((typeof(s)=="undefined")?"":";s"+s.width+"*"+s.height+"*"+
                                (s.colorDepth?s.colorDepth:s.pixelDepth))+";u"+escape(d.URL)+
                            ";h"+escape(d.title.substring(0,150))+";"+Math.random()})
                        (document,screen)</script><!--/LiveInternet-->
                </div>
            </div>
        </div>
    </footer>
</div>
