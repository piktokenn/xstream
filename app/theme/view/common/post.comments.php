<div class="comments" data-content="<?php echo $Config['id'];?>" data-type="<?php echo $Config['type'];?>">
    <?php if(isset($AuthUser['id'])) { ?>
    <form method="POST" class="post-form">
        <div class="comment-form mb-3">
            <div class="row">
                <div class="col-auto">
                    <?php echo gravatar($AuthUser['id'],$AuthUser['username'],$AuthUser['avatar'],'avatar avatar-lg rounded-circle bg-theme text-white fs-sm',$AuthUser['color']);?>
                </div>
                <div class="col">
                    <div class="position-relative">
                        <div class="fw-semibold fs-xs text-white">
                            <?php echo $AuthUser['username'];?>
                        </div>
                        <textarea name="comment" class="form-control px-0 py-2 shadow-none bg-transparent border-0" placeholder="<?php echo $this->translate('Enter your review or comment');?> .." minlength="10" rows="1" wrap="hard" maxlength="255"></textarea>
                        <div class="character-count">255</div>
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-block btn-theme px-xl-4 fs-xs rounded-pill"><?php echo $this->translate('Submit');?></button>
                </div>
            </div>
        </div>
        <div class="comment-alert"></div>
        <input type="hidden" name="post_id" value="<?php echo $Config['id'];?>">
        <input type="hidden" name="_ACTION" value="post">
        <input type="hidden" name="type" value="<?php echo $Config['type'];?>">
        <input type="hidden" name="parent_id" value="">
    </form>
    <?php } else { ?>
    <div class="mb-3 fs-sm">
        <?php echo $this->translate('The comment field is only for members.');?> <a href="<?php echo APP.'/'.$this->translate('login');?>" class="text-current ms-2 fw-semibold">
            <?php echo $this->translate('Login');?></a>, <a href="<?php echo APP.'/'.$this->translate('register');?>" class="text-current fw-semibold">
            <?php echo $this->translate('Register');?></a>
    </div>
    <?php } ?>
    <div class="empty-total text-muted fs-sm"></div>
    <div class="comment-toolbar comment-sorting">
        <ul class="nav nav-active-border">
            <li class="nav-item">
                <a href="#" class="nav-link active" data-sort="1">
                    <?php echo $this->translate('Newest');?></a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-sort="2">
                    <?php echo $this->translate('Most popular');?></a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-sort="3">
                    <?php echo $this->translate('Oldest');?></a>
            </li>
            <li class="nav-item ms-auto comment-total"></li>
        </ul>
    </div>
    <ul class="comments-list"></ul>
    <div class="pagination-container"></div>
</div>
<script id="commentTemplate" type="text/template">
    <li class="comment-list {% if (spoiler == '1') { %} spoiler {% } %}" data-id="{%= id %}">
    {% if (spoiler == '1') { %}
    <div class="spoiler-btn" data-id="{%= id %}">
        <?php echo $this->translate('This comment contains spoilers. Click to read');?>
    </div>
    {% } %}
    <div class="comment-flex">
        <div class="comment-avatar">
            {% if (author.url) { %}
            <a href="{%= author.url %}" target="_blank">{%= author.avatar %}</a>
            {% } else { %}
            {%= author.avatar %}
            {% } %}
        </div>
        <div class="comment-body">
            {% if (author.url) { %}
            <a href="{%= author.url %}" target="_blank" class="comment-name">{%= author.name %}</a>
            {% } else { %}
            <span class="comment-name">{%= author.name %}</span>
            {% } %}
            <a href="#!comment={%= id %}" class="comment-date">
                <time title="{%= created %}">{%= created %}</time>
            </a>
            {% if (status == '2') { %} <span class="text-warning fs-xs">
                <?php echo $this->translate('Pending');?></span> {% } %}
            <div class="comment-text">{%= comment %}</div>
            <form method="POST" class="edit-form comment-form">
                <input type="hidden" name="id" value="{%= id %}">
                <input type="hidden" name="_ACTION" value="update">
                <textarea name="comment" class="form-control mb-1" rows="1 wrap=" hard" maxlength="255" data-content="{%= comment %}" placeholder="<?php echo $this->translate('Enter your comment');?>"></textarea>
                <button type="submit" class="btn btn-block btn-sm btn-ghost px-xl-4 fs-xs">
                    <?php echo $this->translate('Edit');?></button>
                <button type="button" class="btn cancel fs-xs">
                    <?php echo $this->translate('Cancel');?></button>
                <div class="comment-alert"></div>
            </form>
            <div class="comment-footer">
                <div class="votes">
                    <a href="#" title="<?php echo $this->translate('Like');?>" class="like {%= (voted === 'up' ? 'voted' : '') %}">
                        <svg class="icon">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#like';?>" />
                        </svg>
                        <span class="likes" data-votes="{%= likes %}">{%= likes || '' %}</span>
                    </a>
                    <a href="#" title="<?php echo $this->translate('Dislike');?>" class="dislike {%= (voted === 'down' ? 'voted' : '') %}">
                        <svg class="icon">
                            <use xlink:href="<?php echo ASSETS.'/sprite/sprite.svg#dislike';?>" />
                        </svg>
                        <span class="dislikes" data-votes="{%= dislikes %}">{%= dislikes || '' %}</span>
                    </a>
                </div>
                {% if (reply) { %}
                <a href="#" class="reply" data-parent="{%= id %}" data-root="{%= parent_id || id %}">
                    <?php echo $this->translate('Reply');?></a>
                {% } %}
                {% if (edit) { %}
                <a href="#" class="quick-edit">
                    <?php echo $this->translate('Edit');?></a>
                {% } %}
            </div>
            <div class="replybox"></div>
        </div>
    </div>
    <ul class="comments-list children" data-parent="{%= id %}"></ul>
</li>
</script>
<script id="paginationTemplate" type="text/template">
    <ul class="pagination pagination-sm pagination-spaced mt-3">
    <li {% if (current_page===1) { %} class="disabled page-item" {% } %}>
        <a href="#!page={%= prev_page %}" data-page="{%= prev_page %}" title="<?php echo $this->translate('Prev');?>" class="page-link">
            <?php echo $this->translate('Prev');?></a>
    </li>
    {% if (first_adjacent_page > 1) { %}
    <li class="page-item">
        <a href="#!page=1" data-page="1" class="page-link">1</a>
    </li>
    {% if (first_adjacent_page > 2) { %}
    <li class="disabled"><a class="page-link">...</a></li>
    {% } %}
    {% } %}
    {% for (var i = first_adjacent_page; i <= last_adjacent_page; i++) { %} <li class="page-item {% if (current_page === i) { %} active {% } %}">
        <a href="#!page={%= i %}" data-page="{%= i %}" class="page-link">{%= i %}</a>
        </li>
        {% } %}
        {% if (last_adjacent_page < last_page) { %} {% if (last_adjacent_page < last_page - 1) { %} <li class="disabled page-item"><a class="page-link">...</a></li>
            {% } %}
            <li class="page-item"><a href="#!page={%= last_page %}" data-page="{%= last_page %}" class="page-link">{%= last_page %}</a></li>
            {% } %}
            <li class="page-item {% if (current_page === last_page) { %} class=" disabled" {% } %}">
                <a href="#!page={%= next_page %}" data-page="{%= next_page %}" title="<?php echo $this->translate('Next');?>" class="page-link">
                    <?php echo $this->translate('Next');?></a>
            </li>
</ul>
</script>
<script id="alertTemplate" type="text/template">
    <div class="text-warning fs-sm mb-3">
    {% if (typeof message === 'object') { %}
    {% for (var i in message) { %}
    <div>{%= message[i] %}</div>
    {% } %}
    {% } else { %}
    {%= message %}
    {% } %}
</div>
</script>