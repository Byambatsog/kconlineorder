
            </div>
        </div>
        <div id="alert-notification" style="display: none;"></div>

        <script src="<?php echo $app_path ?>gebo/js/jquery-migrate.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/lib/jquery-ui/jquery-ui-1.10.0.custom.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/forms/jquery.ui.touch-punch.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/jquery.easing.1.3.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/jquery.debouncedresize.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/jquery_cookie_min.js"></script>
        <script src="<?php echo $app_path ?>gebo/lib/tag_handler/jquery.taghandler.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/bootstrap.plugins.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/lib/sticky/sticky.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/jquery.actual.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/lib/slimScroll/jquery.slimscroll.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/ios-orientationchange-fix.js"></script>
        <script src="<?php echo $app_path ?>gebo/lib/UItoTop/jquery.ui.totop.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/selectNav.js"></script>
        <script src="<?php echo $app_path ?>gebo/lib/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
        <script src="<?php echo $app_path ?>gebo/lib/smoke/smoke.js"></script>
        <script src="<?php echo $app_path ?>sodon/js/datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo $app_path ?>gebo/js/forms/jquery.inputmask.min.js"></script>


        <script type="text/javascript">
            gebo_submenu = {
                init: function() {
                    $('.dropdown-menu li').each(function(){
                        var $this = $(this);
                        if($this.children('ul').length) {
                            $this.addClass('sub-dropdown');
                            $this.children('ul').addClass('sub-menu');
                        }
                    });

                    $('.sub-dropdown').on('mouseenter',function(){
                        $(this).addClass('active').children('ul').addClass('sub-open');
                    }).on('mouseleave', function() {
                        $(this).removeClass('active').children('ul').removeClass('sub-open');
                    })

                }
            };
            gebo_submenu.init();
            selectnav('mobile-nav', {
                indent: '-'
            });
        </script>
    </div>
</body>
</html>