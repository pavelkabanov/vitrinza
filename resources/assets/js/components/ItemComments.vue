<template>
<div class="comment-block">
    <!-- <p>{{ comments.data }}</p> -->
    <!-- <p>{{ comments }}</p> -->
    <p>Комментарии:</p>

    <div class="item-comment" v-if="$root.user.authenticated">
        <textarea placeholder="Ваш комментарий" class="form-control item-comment__input" v-model="body"></textarea>
        <div class="pull-right">
            <button type="submit" class="btn btn-default" @click.prevent="createComment">Отправить</button>
        </div>
    </div>

    <ul class="media-list">
        <li class="media" v-for="comment in comments">
            <div class="media-left">
                <a :href="'/user/' + comment.user_id">
                    <img v-bind:src="comment.user.data.avatar" :alt="comment.user.data.name" class="media-object">
                </a>
            </div>
            <div class="media-body">
                <a :href="'/user/' + comment.user_id">{{ comment.user.data.name }}</a> <span class="time">{{ comment.created_at_human }}</span>
                <p>{{ comment.body }}</p>

                <ul class="list-inline" v-if="$root.user.authenticated">
                    <li>
                        <a href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Отмена' : 'Ответить' }}</a>
                    </li>
                    <li>
                        <a href="#" v-if="$root.user.id === comment.user_id" @click.prevent="deleteComment(comment.id)">Удалить</a>
                    </li>
                </ul>

                <div class="item-comment clear" v-if="replyFormVisible === comment.id">
                    <textarea class="form-control item-comment__input" v-model="replyBody"></textarea>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-default" @click.prevent="createReply(comment.id)">Ответить</button>
                    </div>
                </div>

                <div class="media" v-for="reply in comment.replies.data">
                    <div class="media-left">
                        <a :href="'/user/' + reply.user_id">
                            <img v-bind:src="reply.user.data.avatar" :alt="reply.user.data.name" class="media-object">
                        </a>
                    </div>
                    <div class="media-body">
                        <a :href="'/user/' + reply.user_id">{{ reply.user.data.name }}</a> <span class="time">{{ reply.created_at_human }}</span>
                        <p>{{ reply.body }}</p>

                        <ul class="list-inline" v-if="$root.user.authenticated">
                            <li>
                                <a href="#" v-if="$root.user.id === reply.user_id" @click.prevent="deleteComment(reply.id)">Удалить</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
</template>

<script>
    export default {
        data () {
            return {
                comments: [],
                body: null,
                replyBody: null,
                replyFormVisible: null
            }
        },
        props: {
            itemSlug: null
        },
        methods: {
            toggleReplyForm (commentId) {
                this.replyBody = null;

                if (this.replyFormVisible === commentId) {
                    this.replyFormVisible = null;
                    return;
                }

                this.replyFormVisible = commentId;
            },
            createReply (commentId) {
                axios.post('/item/' + this.itemSlug + '/comments', {
                    body: this.replyBody,
                    reply_id: commentId
                }).then((response) => {
                    this.comments.map((comment, index) => {
                        if (comment.id === commentId) {
                            this.comments[index].replies.data.push(response.data.data);
                            return;
                        }
                    })

                    this.replyBody = null;
                    this.replyFormVisible = null;
                });
            },
            createComment () {
                axios.post('/item/' + this.itemSlug + '/comments', {
                    body: this.body
                }).then((response) => {
                    this.comments.unshift(response.data.data);
                    this.body = null;
                });
            },
            getComments () {
                axios.get('/item/' + this.itemSlug + '/comments').then((response) => {
                    this.comments = response.data.data;
                    //console.log(response.data);
                    //console.log(this.comments)
                });
            },
            deleteComment (commentId) {
                if (!confirm('Вы уверены, что хотите удалить комментарий?')) {
                    return;
                }

                this.deleteById(commentId);
                axios.delete('/item/' + this.itemSlug + '/comments/' + commentId);
            },
            deleteById (commentId) {
                this.comments.map((comment, index) => {
                    if (comment.id === commentId) {
                        this.comments.splice(index, 1);
                        return;
                    }

                    comment.replies.data.map((reply, replyIndex) => {
                        if (reply.id === commentId) {
                            this.comments[index].replies.data.splice(replyIndex, 1);
                            return;
                        }
                    })
                });
            }
        },
        mounted () {
            this.getComments();
        }
    }
</script>