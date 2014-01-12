<section>                
    <article class="one-colomn">
        <div class="block-right">
            <h3>אירועים הבאים</h3>
            <?php do_shortcode('[my_bookings limit=3]'); ?>
        </div>
        <div class="block-left">
            <h3>באנר/אירוע מרכזי</h3>
            <?php do_shortcode('[my_bookings limit=1]'); ?>
        </div>
    </article>
    
    <article class="one-colomn">
        <div class="block-right">
            <?php showPostsCategory( 3, 'post', $category );?>
        </div>
        <div class="block-left">
            <?php showPostsCategory( 3, 'solution', $category );?>
        </div>
        <div class="block-left">
            <h3>אירגון החודש</h3>
            <p> 
                sdfdbshfbhdjs</br>
                sdfdbshfbhdjs</br>
                sdfdbshfbhdjs
            </p>
        </div>
    </article>
    
    <article class="one-colomn">
        <div class="block-right">                                    
            <?php showPostsCategory( 3, 'post', $category );?>
        </div>
    </article>
    
    <article class="one-colomn">
        <?php echo do_shortcode('[events_list]'); ?>
    </article>	                            
</section>