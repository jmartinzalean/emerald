<div>
    <label class="label" for="<?php echo $id; ?>"><?php echo  $text; ?></label>
    <select name="<?php echo  $id; ?>" id="<?php echo  $id; ?>">
        <option value="0">Elija una opción...</option>
        <?php foreach ( $options as $key => $option): ?>
        <option value="<?php echo $key; ?>"<?php if($current==$key): echo 'selected'; endif;?>><?php echo $option; ?></option>
        <?php endforeach; ?>
    </select>
</div>
