<div class="jumbotron">
<p><?php echo $this->Html->link('View All Users',array('action' => 'index'));?></p>
<h1><?php echo h($user['User']['username']); ?></h1>

<p><small>Created: <?php echo $user['User']['created']; ?></small></p>

<p><?php echo h($user['User']['role']); ?></p>
<p><?php echo 'You have '.count($user['Post']).' Posts'?></p>
<p><?php echo h($user['Post'][0]['title'])?></p>
<p><?php echo h($user['Post'][0]['body'])?></p>
<p><?php echo h($user['Post'][0]['created'])?></p>
</div> 