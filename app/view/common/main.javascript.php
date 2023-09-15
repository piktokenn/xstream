<?php 
$UserTotal  = null;
$UserDate  = null; 
foreach ($Users as $User) {
    $UserTotal  .= $User['total'].',';
    $UserDate   .= '"'.dating($User['created']).'",';
} 
?>
<script src="<?php echo ASSETS.'/js/chart.js?v='.VERSION;?>"></script>
<script type="text/javascript">
(function($) {
    'use strict';
    // Earning chart
    if ($("#stat").length) {

        var tax_data = [
            { "period": "1", "licensed": 10, "sorned": 16 },
            { "period": "2", "licensed": 20, "sorned": 14 },
            { "period": "3", "licensed": 30, "sorned": 12 },
            { "period": "4", "licensed": 26, "sorned": 11 },
            { "period": "5", "licensed": 21, "sorned": 10 },
            { "period": "6", "licensed": 64, "sorned": 15 },
            { "period": "7", "licensed": 32, "sorned": 16 }
        ];
        Morris.Area({
            element: 'stat',
            data: tax_data,
            xkey: 'period',
            ykeys: ['licensed', 'sorned'],
            labels: ['Licensed', 'Off the road'],
            gridLineColor: "rgba(65, 80, 95, 0.07)",
            lineWidth: "5px",
            pointSize: 0,
            fillOpacity: 0.25,
            pointSize: 6,
            behaveLikeLine: !0,
            lineColors: ["#007aff", "#F44336"],
            barRatio: 0.4,
            smooth: true,
            hideHover: 'auto'
        });
    }


})(jQuery);
</script>