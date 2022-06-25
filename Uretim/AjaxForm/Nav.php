<?php $kisa="document.querySelector";?>
<script>
    $.Sirala=function (deneme,abc){
        var ustDiv = <?=$kisa?>(".Sirala");
        ustDiv.insertBefore(deneme, abc);
    };

    //Sıralama
    $.Setadi=function () {
        var a = <?=$kisa?>(".s1");
        var b = <?=$kisa?>(".s8");
        $.Sirala(a, b);
    }
    $.UrunSec=function () {
        var a = <?=$kisa?>(".s2");
        var b = <?=$kisa?>(".s8");
        $.Sirala(a,b);
    }
    $.GeriSetadi=function () {
        var a = <?=$kisa?>(".s1");
        var b = <?=$kisa?>(".s2");
        $.Sirala(a,b);
    }
    $.KulpSec=function () {
        var a = <?=$kisa?>(".s3");
        var b = <?=$kisa?>(".s8");
        $.Sirala(a,b);
    }
    $.KapakSec=function () {
        var a = <?=$kisa?>(".s4");
        var b = <?=$kisa?>(".s8");
        $.Sirala(a,b);
    }
    $.TepeSec=function () {
        var a = <?=$kisa?>(".s5");
        var b = <?=$kisa?>(".s8");
        $.Sirala(a,b);
    }
    $.Secimler=function () {
        var a = <?=$kisa?>(".s6");
        var b = <?=$kisa?>(".s8");
        $.Sirala(a,b);
    }
</script>