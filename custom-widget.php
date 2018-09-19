/**************Custom Widget********************/
# PHP 5.3+ anonymous function
add_action( 'widgets_init', function() {
    register_widget( 'Blue_widget' );
});

class Blue_widget extends WP_Widget
{
    function Blue_widget()
    {
        $this->WP_Widget(
            'hottopics',
            __('Multiple Pages'),
            array(
                'name' => 'Multiple Pages',
                'classname' => 'widget-multiple-pages',
                'description' => __( "A list of your site’s Pages." )
            )
        );
    }

    function form( $instance )
    {

        $firstpage = $instance['firstpage'];
        $secondpage = $instance['secondpage'];
        $thirdpage = $instance['thirdpage'];
        $title   = $instance['title'];
        $ctext   = $instance['ctext'];
        $btntext   = $instance['btntext'];
        $btnlink   = $instance['btnlink'];

        $get_posts = get_posts( array(
            'offset'=> 1,
            'orderby' => 'title',
            'order' => 'ASC',
            'post_type' => 'page',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));

        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                           name="<?php echo $this->get_field_name('title'); ?>" type="text"
                           value="<?php echo $title; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('ctext'); ?>">Content:

                    <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('ctext'); ?>"
                              name="<?php echo $this->get_field_name('ctext'); ?>"><?php echo $ctext; ?></textarea>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('btntext'); ?>">Button Text:
                    <input class="widefat" id="<?php echo $this->get_field_id('btntext'); ?>"
                           name="<?php echo $this->get_field_name('btntext'); ?>" type="text"
                           value="<?php echo $btntext; ?>" />
                </label>

                <label>Link Page:
                    <select style="margin-bottom: 10px;margin-top: 10px;width: 100%;" class='widefat' id="<?php echo $this->get_field_id('btnlink'); ?>"
                            name="<?php echo $this->get_field_name('btnlink'); ?>" type="text">
                        <?php

                        foreach( $get_posts as $post )
                        {
                            echo "<option value='";
                            echo $post->ID;
                            echo "'";
                            if($btnlink == $post->ID){ echo " selected='selected'";}
                            echo "style='margin-bottom:3px;'>";
                            echo $post->post_title;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </label>

            </p>

            <label for="<?php echo $this->get_field_id('text'); ?>">Select First Page:
                <select style="margin-bottom: 10px;margin-top: 10px;width: 100%;" class='widefat' id="<?php echo $this->get_field_id('firstpage'); ?>"
                        name="<?php echo $this->get_field_name('firstpage'); ?>" type="text">
                    <?php

                    foreach( $get_posts as $post )
                    {
                        echo "<option value='";
                        echo $post->ID;
                        echo "'";
                        if($firstpage == $post->ID){ echo " selected='selected'";}
                        echo "style='margin-bottom:3px;'>";
                        echo $post->post_title;
                        echo "</option>";
                    }
                    ?>
                </select>
            </label>

            <label for="<?php echo $this->get_field_id('text'); ?>">Select Second Page:
                <select style="margin-bottom: 10px;margin-top: 10px;width: 100%;" class='widefat' id="<?php echo $this->get_field_id('secondpage'); ?>"
                        name="<?php echo $this->get_field_name('secondpage'); ?>" type="text">
                    <?php
                        foreach( $get_posts as $post )
                        {
                            echo "<option value='";
                            echo $post->ID;
                            echo "'";
                            if($secondpage == $post->ID){ echo " selected='selected'";}
                            echo "style='margin-bottom:3px;'>";
                            echo $post->post_title;
                            echo "</option>";
                        }
                    ?>
                </select>
            </label>

            <label for="<?php echo $this->get_field_id('text'); ?>">Select Third Page:
                <select style="margin-bottom: 10px;margin-top: 10px;width: 100%;" class='widefat' id="<?php echo $this->get_field_id('thirdpage'); ?>"
                        name="<?php echo $this->get_field_name('thirdpage'); ?>" type="text">
                    <?php
                    foreach( $get_posts as $post )
                    {
                        echo "<option value='";
                        echo $post->ID;
                        echo "'";
                        if($thirdpage == $post->ID){ echo " selected='selected'";}
                        echo "style='margin-bottom:3px;'>";
                        echo $post->post_title;
                        echo "</option>";
                    }
                    ?>
                </select>
            </label>

        <?php
    }

    function update( $new_instance, $old_instance )
    {

        $instance = array();
        $instance['firstpage']  = ( !empty( $new_instance['firstpage'] ) ) ? strip_tags( $new_instance['firstpage'] ) : '';
        $instance['secondpage'] = ( !empty( $new_instance['secondpage'] ) ) ? strip_tags( $new_instance['secondpage'] ) : '';
        $instance['thirdpage']  = ( !empty( $new_instance['thirdpage'] ) ) ? strip_tags( $new_instance['thirdpage'] ) : '';
        $instance['title']   = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['ctext']   = ( !empty( $new_instance['ctext'] ) ) ? strip_tags( $new_instance['ctext'] ) : '';
        $instance['btntext'] = ( !empty( $new_instance['btntext'] ) ) ? strip_tags( $new_instance['btntext'] ) : '';
        $instance['btnlink'] = ( !empty( $new_instance['btnlink'] ) ) ? strip_tags( $new_instance['btnlink'] ) : '';

        return $instance;

    }

    function widget( $args, $instance )
    {
        $firstpage  = $instance['firstpage'];
        $secondpage = $instance['secondpage'];
        $thirdpage  = $instance['thirdpage'];
        $title   = $instance['title'];
        $ctext = $instance['ctext'];
        $btntext   = $instance['btntext'];
        $btnlink   = $instance['btnlink']; ?>

        <div class="panel_graphic">
            <div class="hidden-xs">
                <h3><?php echo $title; ?></h3>
                <p><?php echo $ctext; ?> </p>
                <a href="<?php echo get_the_permalink($btnlink); ?>" class="large_btn blue"><?php echo $btntext; ?></a>
            </div>
            <div class="hidden-xs hidden-sm">
                <!--show sidebar graphics for desktop and above -->
                <?php if($firstpage) {?>
                    <figure class="effect-sarah">
                        <a href="<?php echo get_the_permalink($firstpage); ?>" target="_self">
                            <img alt="" src="<?php echo get_the_post_thumbnail_url($firstpage); ?>" class="img-responsive">
                            <figcaption>
                                <h2><?php echo get_the_title($firstpage); ?></h2>
                            </figcaption>
                        </a>
                    </figure>
                <?php } ?>

                <?php if ($secondpage) {?>
                    <figure class="effect-sarah">
                        <a href="<?php echo get_the_permalink($secondpage); ?>" target="_self">
                            <img alt="" src="<?php echo get_the_post_thumbnail_url($secondpage); ?>" class="img-responsive">
                            <figcaption>
                                <h2><?php echo get_the_title($secondpage); ?></h2>
                            </figcaption>
                        </a>
                    </figure>
                <?php } ?>

                <?php if ($thirdpage) {?>
                    <figure class="effect-sarah">
                        <a href="<?php echo get_the_permalink($thirdpage); ?>" target="_self">
                            <img alt="" src="<?php echo get_the_post_thumbnail_url($thirdpage); ?>" class="img-responsive">
                            <figcaption>
                                <h2><?php echo get_the_title($thirdpage); ?></h2>
                            </figcaption>
                        </a>
                    </figure>
                <?php } ?>
            </div>

        </div>
<?php
    }
}
