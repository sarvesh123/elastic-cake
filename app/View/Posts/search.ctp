<div class="posts index">
	<h2><?php echo __('Posts'); ?></h2>
    <?php if ( $posts ) : ?>
    	<table cellpadding="0" cellspacing="0">
    	<thead>
    	<tr>
    			<th><?php echo $this->Paginator->sort('id'); ?></th>
    			<th><?php echo $this->Paginator->sort('title'); ?></th>
                <th><?php echo $this->Paginator->sort('price'); ?></th>
    			<th><?php echo $this->Paginator->sort('body'); ?></th>
    			<th><?php echo $this->Paginator->sort('created'); ?></th>
    			<th><?php echo $this->Paginator->sort('modified'); ?></th>
    			<th class="actions"><?php echo __('Actions'); ?></th>
    	</tr>
    	</thead>
    	<tbody>
    	<?php foreach ($posts as $post): ?>
    	<tr>
    		<td><?php echo h($post['Post']['id']); ?>&nbsp;</td>
    		<td><?php echo h($post['Post']['title']); ?>&nbsp;</td>
            <td><?php echo h($post['Post']['price']); ?>&nbsp;</td>
    		<td><?php echo h($post['Post']['body']); ?>&nbsp;</td>
    		<td><?php echo h($post['Post']['created']); ?>&nbsp;</td>
    		<td><?php echo h($post['Post']['modified']); ?>&nbsp;</td>
    		<td class="actions">
    			<?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?>
    		</td>
    	</tr>
        <?php endforeach; ?>
    	</tbody>
    	</table>
     <?php else : ?>
        <span><?php echo __('No Posts Found'); ?></span>
     <?php endif; ?>
</div>
<div class="actions">
	<form>
		<ul>
			<li><input id="search" type="text" name="search" placeholder="Search" value="<?php echo isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0]: ''; ?>" ></li>
            <li><input id="max-price" type="text" name="max-price" placeholder="Max Price" value="<?php echo isset($this->request->params['named']['max-price']) ? $this->request->params['named']['max-price']: ''; ?>" ></li>
            <li><input id="min-price" type="text" name="min-price" placeholder="Min Price" value="<?php echo isset($this->request->params['named']['min-price']) ? $this->request->params['named']['min-price']: ''; ?>" ></li>
            <li><input type="submit" onclick="submitSearch();return false;"></li>
        </ul>
	</form>
</div>
<script type="text/javascript" src="/js/search.js"></script>