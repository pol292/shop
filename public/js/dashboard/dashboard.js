var createTree = function tree(data) {
    var end = data.length;
    var ret = '';
    for (var i = 0; i < end; i++) {
        if (data[i].title) {
            ret += '<li class="dd-item dd3-item" data-id="' + data[i].id + '">' +
                    '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">' +
                    data[i].title + '<div class="btn-group btn-group-xs pull-right" role="group">' +
                    '<a href="#" class="btn btn-xs btn-primary edit-content" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></a>' +
                    '<a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-route="dashboard/CMS/content/delete/' + data[i].id + '" data-msg="Did you want to delete (' + data[i].title + ') this content" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-trash"></span></a>' +
                    '</div></div><div class="page-article">' +
                    '<input type="hidden" name="content-id" value="' + data[i].id + '">' +
                    '<label for="' + data[i].id + '">Tilte: </label>' +
                    '<input id="' + data[i].id + '" type="text" name="title" value="' + data[i].title + '">' +
                    '<article name="article" class="summernote">' + data[i].article + '</article>' +
                    '<button class="btn btn-danger pull-left edit-close">Cancel</button>' +
                    '<button class="btn btn-primary pull-right save-content">Save</button>' +
                    '<div class="clearfix"></div>' +
                    '</div>';

            if (data[i].childs) {
                ret += '<ol class="dd-list">' + tree(data[i].childs) + '</ol>';
            }
            ret += '</li>';

        } else if (data[i].childs) {
            var data = tree(data[i].childs);
            if (data)
                ret += '<ol class="dd-list">' + data + '</ol>';
        }
    }
    return ret;
};


$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (typeof page_data !== 'undefined') {
        page_content = createTree(page_data);
        if (!page_content) {
            page_content = '<div class="alert alert-warning">No Content in this page</div>';
        }
        $('#drag_content').html(page_content);
    }
    $('.summernote').summernote();
    $('[data-toggle="tooltip"]').tooltip();
    $('#sm').delay(5000).fadeOut(500);
    var updateOutput = function (e)
    {
        var list = e.length ? e : $(e.target);
        if (window.JSON) {
            var json_list = JSON.stringify(list.nestable('serialize'));
            json_list = JSON.parse(json_list);
            var recToArr = function rec(arr, data, parent = false) {
                var end = arr.length;
                for (var i = 0; i < end; i++) {
                    data[arr[i]['id']] = {
                        'page_contents_id': (parent) ? parent : 0,
                        'sort': i
                    };
                    if (typeof arr[i]['children'] !== 'undefined' && arr[i]['children'] !== null) {
                        rec(arr[i]['children'], data, arr[i]['id']);
                    }
            }
            };
            var data = {};
            recToArr(json_list, data);
            $.ajax({
                url: URL + 'dashboard/CMS/content/update-sort',
                type: "PUT",
                dataType: "html",
                data: {'data': data},
            });
        }
    };
    $('#drag_content').nestable().on('change', updateOutput);
    $(document).on('click', '.edit-content', function () {
        var article = $(this).parent().parent().next();
        $('.edit-content').addClass('btn-primary').removeClass('btn-danger').children('span').removeClass('fa-ban').addClass('fa-edit');
        $('.page-article').fadeOut(200);
        if (article.css('display') == 'none') {
            article.fadeIn(500);
            $(this).addClass('btn-danger').removeClass('btn-primary').children('span').removeClass('fa-edit').addClass('fa-ban');
        }
    }).on('click', '.edit-close', function () {
        $('.page-article').fadeOut(200);
        $('.edit-content').addClass('btn-primary').removeClass('btn-danger').children('span').removeClass('fa-ban').addClass('fa-edit');
    }).on('click', '.edit-page-btn', function () {
        var edit = $('.edit-page');
        if (edit.css('display') == 'none') {
            $(edit).fadeIn(1000);
            $('.edit-page-btn-change').addClass('btn-danger').removeClass('btn-default').children('span').removeClass('fa-edit').addClass('fa-ban');
        } else {
            $(edit).fadeOut(500);
            $('.edit-page-btn-change').addClass('btn-default').removeClass('btn-danger').children('span').removeClass('fa-ban').addClass('fa-edit');
        }
    }).on('click', '.save-content', function () {

        var form = $(this).parent('.page-article'),
                data = {
                    'id': form.children('input[name="content-id"]').val(),
                    'content-title': form.children('input[name="title"]').val(),
                    'article': form.children('article[name="article"]').summernote('code').toString()
                };
        $.ajax({
            url: URL + 'dashboard/CMS/content/update',
            type: "PUT",
            dataType: "html",
            data: data,
            success: function (data) {
                location.reload();
            }
        });
    }).on('keyup', '.friendly-url', function () {
        var friendly_url = $(this).val().trim().toLowerCase().replace(/[^a-z0-9\s\-]/g, '').replace(/[\s]+/g, '-');
        $('.friendly-url-paste').val(friendly_url);
    });

    $('#delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        var data = {};
        if (button.data('redirect') !== undefined) {
            data.redirect = button.data('redirect');
        }
        modal.find('#delete-msg').text($(button).data('msg'));
        modal.find('#send-delete').on('click', function () {
            $.ajax({
                url: URL + button.data('route'),
                type: "DELETE",
                dataType: "json",
                data: data,
                success: function (data) {
                    if (typeof data['redirect'] !== 'undefined') {
                        location.href = URL + data['redirect'];
                    } else {
                        location.reload();
                    }
                }
            });
        });
    })

});

