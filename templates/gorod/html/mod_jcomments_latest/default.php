<?php
// no direct access
defined('_JEXEC') or die;
?>
<?php if (!empty($list)) :?>
<div class="jcomments-latest<?php echo $params->get('moduleclass_sfx'); ?>">
<?php if ($grouped) : ?>
	<?php foreach ($list as $group_name => $group) : ?>
	<div class="latest-item">
		<div>
			<?php $i = 0; $n = count($group); ?>
			<?php foreach ($group as $item) : ?>
			<div>
				<?php if ($params->get('show_avatar')) :?>
					<?php echo $item->avatar; ?>
				<?php endif; ?>

		<h<?php echo $item_heading; ?>>
			<?php if ($params->get('link_object_title') && $group[0]->object_link != '') : ?>
				<a href="<?php echo $group[0]->object_link;?>"><?php echo $group_name;?></a>
			<?php else : ?>
				<?php echo $group_name; ?>
			<?php endif; ?>
		</h<?php echo $item_heading; ?>>
		
				<?php if ($params->get('show_comment_author')) :?>
				<span class="author"><?php echo $item->displayAuthorName; ?></span>
				<?php endif; ?>
				<?php if ($params->get('show_comment_date')) :?>
				<span class="date"><?php echo $item->displayDate; ?></span>
				<?php endif; ?>

				<div class="comment rounded<?php echo $params->get('show_avatar') ? ' avatar-indent' : '';?>">
					<?php if ($params->get('show_comment_title') && $item->displayCommentTitle) :?>
					<a class="title" href="<?php echo $item->displayCommentLink; ?>" title="<?php echo htmlspecialchars($item->displayCommentTitle); ?>">
						<?php echo $item->displayCommentTitle; ?>
					</a>
					<?php endif; ?>
					<div>
						<?php echo $item->displayCommentText; ?>
						<?php if ($params->get('readmore')) : ?>
						<p class="jcomments-latest-readmore">
							<a href="<?php echo $item->displayCommentLink; ?>"><?php echo $item->readmoreText; ?></a>
						</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if ($n > 1 && ($i < $n - 1)) :?>
				<span class="comment-separator">&#160;</span>
				<?php endif; ?>
			</div>
			<?php $i++; ?>
		<?php endforeach; ?>
		</div>
	</div>
	<?php endforeach; ?>

<?php else : ?>
	
	<?php $i = 0; $n = count($list); ?>
	<?php foreach ($list as $item) : ?>
	<div class="latest-item">
		<div class="latest-avatar">
			<div class="avatarka">
			<?php if ($params->get('show_avatar')) :?>
				<?php echo $item->avatar; ?>
			<?php endif; ?>
			</div>
		<?php if ($params->get('show_comment_date')) :?>
			<div class="date"><?php echo $item->displayDate; ?></div>
		<?php endif; ?>		
		</div
		><div class="mod_tema">
		<div class="tema_padding">
			<div class="latest-subject">	
				<a href="<?php echo $item->object_link;?>"><?php echo $item->displayObjectTitle; ?></a>
			</div>
		
		<div class="comment rounded <?php echo $params->get('show_avatar') ? 'avatar-indent' : '';?>">
		<?php if ($params->get('show_comment_title') && $item->displayCommentTitle) :?>
			<a class="title" href="<?php echo $item->displayCommentLink; ?>" title="<?php echo htmlspecialchars($item->displayCommentTitle); ?>">
				<?php echo $item->displayCommentTitle; ?>
			</a>
			<?php endif; ?>
			<div class="latest-preview-content">
				<?php echo mb_substr($item->displayCommentText, 0, 150,'UTF-8').'...'; ?>
				<?php if ($params->get('readmore')) : ?>
				<p class="jcomments-latest-readmore">
					<a href="<?php echo $item->displayCommentLink; ?>"><?php echo $item->readmoreText; ?></a>
				</p>
				<?php endif; ?>
			</div>
		</div>
		
		<?php if ($params->get('show_comment_author')) :?>
			<span class="author"><?php echo $item->displayAuthorName; ?></span>
		<?php endif; ?>
	</div>
	</div>
	</div>
	<?php $i++; ?>
	<?php endforeach; ?>
<?php endif; ?>
</div>

<?php endif; ?>
