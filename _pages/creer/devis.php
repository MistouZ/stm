<?php

/**
 * @author Nicolas
 * @copyright 2019
 */



?>
<script>
    $(document).ready(function(){
        $('#bonus').change(function() {
            alert($("#bonus option:selected").value());
        });
    });
</script>
<select id="bonus">
    <option value="1">-$5000</option>
    <option value="2">-$2500</option>
    <option value="3">$0</option>
    <option value="4">$1</option>
    <option value="5">We really appreciate your work</option>
</select>
