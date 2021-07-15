<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <div style="clear:both;"></div>  
    <div class="col-12">
        <div class="box-info">
            <div class="box-header">
                <h3 class="box-title"><?php _e( 'Záznamy logu', 'plan' ); ?></h3>
            </div>
            <div class="box-body">
                <?php 
                
                /*$idoklad_log = iDoklad_Log::get_instance();
                echo $idoklad_log->render_table();*/
                $settings = new wedesinLogSettings;
                echo $settings->get_print_log();

                ?>
            </div>
        </div>                 
    </div>
</div>
<div style="clear:both;"></div>  