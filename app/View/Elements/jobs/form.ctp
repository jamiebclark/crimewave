<?php
echo $this->Form->create();
echo $this->Form->hidden('id');
echo $this->Form->hidden('game_id');
echo $this->Form->input('title');
echo $this->Form->end('Update');