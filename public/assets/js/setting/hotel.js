$(function(){
    toggle_art_setting();
    $('[name=art_link_flg]').on('change', function(){
        toggle_art_setting();
    });
})

function toggle_art_setting() {
    if($('[name=art_link_flg]:checked').val() == '1'){
        $('.artSetting').show();
    } else {
        $('.artSetting').hide();
    }
}
