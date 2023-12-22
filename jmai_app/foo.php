<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up">
        <span class="path1"></span>
        <span class="path2"></span>
    </i>
</div>

<script>
    var hostUrl = "assets/";
    var api_base_url = "http://localhost:8888/api/";
</script>

<script src="<?php echo $link_home; ?>assets/plugins/global/plugins.bundle.js"></script>
<script src="<?php echo $link_home; ?>assets/js/scripts.bundle.js"></script>

<script src="<?php echo $link_home; ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/pt.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/pt.min.js"></script>
<script src="<?php echo $link_home; ?>assets/plugins/custom/datatables/datatables.bundle.js"></script>


<script src="<?php echo $link_home; ?>assets/js/widgets.bundle.js"></script>
<script src="<?php echo $link_home; ?>assets/js/custom/widgets.js"></script>
<script src="<?php echo $link_home; ?>assets/js/custom/apps/chat/chat.js"></script>
<script src="<?php echo $link_home; ?>assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="<?php echo $link_home; ?>assets/js/custom/utilities/modals/users-search.js"></script>

<script>
    $.fn.select2.defaults.set('language', 'pt-PT');
    flatpickr.localize(flatpickr.l10ns.pt);
    flatpickr.setDefaults({
        dateFormat: "d/m/Y",
    });
    const token = Cookies.get("token") || "";
</script>

<script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>