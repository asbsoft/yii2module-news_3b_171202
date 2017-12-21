<?php //echo __FILE__;
//var_dump($this->blocks);exit;
?>
<!--
x BEGIN:TEST-EXT-3B<br>

<h2>x <?= $t ?></h2>

x 3B: This text is out of "parent"<br />
-->
<?php $this->startParent() ?>

++3B)#1  This text will be lost ...<br /><br />

<?php $this->startBlock('header') ?>

   ++3B)begin parentBlock...<br>
   <?php $this->parentBlock() ?>
   ++3B)...end parentBlock.<br>

   ++3B)Start block 'header'...<br />
   <h3>3B redefined header</h3>
   <?= $s ?><br />
   ++3B)...stop block 'header'.<br /><br />

<?php $this->stopBlock('header') ?>

++3B)#2  This text will be lost ...<br /><br />

<?php //$this->startBlock('outer') ?>
    ++3B)Start block 'outer'...<br />

    <?php //$this->startBlock('outer/inner') ?>
        ++3B)Start block '[outer/]inner'...<br />

        ++3B)begin parentBlock...<br>
        <?php //$this->parentBlock() ?>
        ++3B)...end parentBlock.<br>

        ++3B) some data: N = <?= $n ?><br />

        ++3B)...stop block '[outer/]inner'.<br /><br />
    <?php //$this->stopBlock('outer/inner') ?>

    ++3B)...stop block 'outer'.<br /><br />
<?php //$this->stopBlock('outer') ?>

++3B)#9  This text will be lost ...<br /><br />

<?php $this->stopParent() ?>
<!--
x 3B: This text is out of "parent"<br />

x END:TEST-EXT-3B<br>
-->
