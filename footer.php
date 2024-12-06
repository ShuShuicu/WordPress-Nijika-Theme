<?php
if (!defined('ABSPATH')) exit;
?>
</div>
<?php Get::Src('Sidebar'); ?>
</div>
        </div>
        <div id="Footer">
        <footer style="margin-top: auto;">
    <div class="mdui-valign"><img src="<?php echo Get::AssetsUrl(); ?>/images/end.png" class="mdui-center mdui-img-fluid"></div>
    <div class="mdui-card" style="border-radius: 0px;">
        <div class="mdui-container mdui-typo">
            <div class="mdui-row mdui-p-y-4">
                <div class="mdui-col-xs-4 mdui-col-md-3 mdui-col-offset-md-1">
                    <div class="mdui-float-left">
                        <div>基于 <a href="https://cn.wordpress.org/" target="_blank">WordPress</a> · <a href="https://space.bilibili.com/435502585" target="_blank">Nijika</a></div>
                    </div>
                </div>
                <div class="mdui-col-xs-4 mdui-col-md-4">
                    <div class="mdui-text-center">
                        <div>© <?php echo date("Y"); ?> <a href="<?php echo Get::HomeUrl('/'); ?>"><b><?php echo Get::Info('name'); ?></b></a> 版权所有</div>
                    </div>
                </div>
                <div class="mdui-col-xs-4 mdui-col-md-3">
                    <div class="mdui-float-right">
                        <div>
                            <?php 
                                $ICP = Get::Options('NijikaOptions_ICP', '');
                                $LoadTime = get_load_time();
                                if ($ICP == '') {
                                    echo '加载时间 ' . $LoadTime . ' 秒';
                                } else {
                            ?>
                                <a href="https://beian.miit.gov.cn/" target="_blank" rel="external nofollow noopener"><?php echo $ICP ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
        </div>
    </div>
<?php 
    $jsFiles = [
        'translate.min',
        'view-image.min',
        'code/prism.full',
        'mdui/js/mdui.min',
        'jquery/jquery.min',
        'jquery/jquery.pjax.min',
        'nprogress/nprogress.min',
        'pjax',
    ];
    foreach ($jsFiles as $js){ ?>
    <script src="<?php echo Get::AssetsUrl() . "/" . $js . '.js?ver=' . Get::ThemeVersion(); ?>"></script>
<?php 
}; 
wp_footer(); 
?>

</body>
</html>