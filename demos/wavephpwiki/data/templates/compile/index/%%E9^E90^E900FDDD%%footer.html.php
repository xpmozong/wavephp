<?php /* Smarty version 2.6.25-dev, created on 2015-12-25 18:07:32
         compiled from layout/footer.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "layout/debuger.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- <p id="back-top" style="display: block;">
    <a href="javascript:;"></a>
</p> -->
<script type="text/javascript">
    $(function () {
        $("table").addClass('table table-bordered');

        // // hide #back-top first
        // $("#back-top").hide();

        // // fade in #back-top
        // $(window).scroll(function () {
        //     if ($(this).scrollTop() > 400) {
        //         $('#back-top').fadeIn();
        //     } else {
        //         $('#back-top').fadeOut();
        //     }
        // });

        // // scroll body to 0px on click
        // $('#back-top a').click(function () {
        //     $('body,html').animate({
        //         scrollTop: 0
        //         }, 800);
        //     return false;
        // });
    });
</script>
</body>
</html>