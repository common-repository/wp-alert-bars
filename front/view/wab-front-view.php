<?php 
$wab_settings = get_option('wab_settings'); 
if(array_key_exists( strtolower($wabAttr['name']), $wab_settings )):
?>
<div class="wab-alert-front <?php esc_attr_e(strtolower($wabAttr['name'])); ?>" style="background: <?php esc_attr_e($wab_settings[strtolower($wabAttr['name'])]['wab_bg_color']); ?>; color:#FFF;">
  <span class="wab-front-closebtn">&times;</span>
  <b><?php esc_attr_e(ucfirst(strtolower($wabAttr['name']))); ?></b>, 
  <?php 
  if( isset($wabAttr['desc']) && ('' !== $wabAttr['desc']) ):
    esc_html_e($wabAttr['desc']);
  else:
    esc_html_e($wab_settings[strtolower($wabAttr['name'])]['wab_description']);
  endif;
  ?>
</div>
<?php endif; ?>