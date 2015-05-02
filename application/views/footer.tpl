           </div> <!-- end of movie list -->
        </div> <!-- end of div content -->
    </div> <!-- end of div frame  -->
    <script type="application/javascript" src="/js/jquery-1.11.2.min.js"></script>
    <script type="application/javascript">
        jQuery(document).ready(function() {
            jQuery("div.month_list a").click(function(ev, elem) {
                ev.preventDefault();
                var uri = jQuery(this).attr('href');
                
                jQuery('div.month_list a.active').removeClass('active');
                jQuery(this).addClass('active');
                
                jQuery('div.movie_list').fadeOut(100, function() {
                    jQuery.ajax({
                        url: uri,
                        success: function(data) {
                            jQuery("div.movie_list").html(data);
                            jQuery('div.movie_list').fadeIn();
                        }
                    });
                });
            });
        });
    </script>
    </body>
</html>