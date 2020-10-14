<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>

<?php
if (isset($post) || isset($page)) {
    $cid = isset($post) ? $post->cid : $page->cid;
    
    if ($cid) {
        Typecho_Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $cid)->to($attachment);
    } else {
        Typecho_Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
}
?>

<div id="upload-panel" class="p">
    <div class="upload-area" draggable="true"><?php _e('拖放文件到这里<br>或者 %s选择文件上传%s', '<a href="###" class="upload-file">', '</a>'); ?></div>
    <ul id="file-list">
    <?php _e(' %s删除全部缓存附件%s <br>', '<a href="###" class="upload-file-delete" onclick="attachDeleteALL()">' , '</a>'); ?>
    <?php while ($attachment->next()): ?>
        <li data-cid="<?php $attachment->cid(); ?>" data-url="<?php echo $attachment->attachment->url; ?>" data-image="<?php echo $attachment->attachment->isImage ? 1 : 0; ?>"><input type="hidden" name="attachment[]" value="<?php $attachment->cid(); ?>" />
            <a class="insert" title="<?php _e('点击插入文件'); ?>" href="###"><?php $attachment->title(); ?></a>
            <div class="info">
                <?php echo number_format(ceil($attachment->attachment->size / 1024)); ?> Kb
                <a class="file" target="_blank" href="<?php $options->adminUrl('media.php?cid=' . $attachment->cid); ?>" title="<?php _e('编辑'); ?>"><i class="i-edit"></i></a>
                <a href="###" class="delete" title="<?php _e('删除'); ?>"><i class="i-delete"></i></a>
            </div>
        </li>
    <?php endwhile; ?>
    </ul>
</div>
<script>
	function attachDeleteALL () {
	$("body").one('click','.upload-file-delete',function(){
          if(confirm('确认要删除全部文件吗?')){
            var actionUrl = $(".row typecho-page-main typecho-post-area").context.forms.write_post.action
            var idlists = document.getElementById('file-list').getElementsByTagName('li')
            for (var i=0;i<idlists.length;i++)
                { 
                  var dataid = idlists[i].attributes[0].value
                  $.post(actionUrl,
                    {'do' : 'delete', 'cid' : dataid},
                    function () {
                            idlists[0].remove();
                            var btn = $('#tab-files-btn'),
                                balloon = $('.balloon', btn),
                                count = $('#file-list li .insert').length;

                            if (count > 0) {
                                if (!balloon.length) {
                                    btn.html($.trim(btn.html()) + ' ');
                                    balloon = $('<span class="balloon"></span>').appendTo(btn);
                                }

                                balloon.html(count);
                            } else if (0 == count && balloon.length > 0) {
                                balloon.remove();
                            }
                        });
                }
                //alert('test successed!');
          	console.log("modify by popcc")
             }
        })
    }
</script>
