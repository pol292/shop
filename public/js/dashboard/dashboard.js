/*
 * pages js
 */

var createTree = function tree(data, level) {
    var end = data.length;
    var ret = '';
    for (var i = 0; i < end; i++) {
        if (data[i].title) {
            ret += '<li class="dd-item dd3-item" data-id="' + data[i].id + '">' +
                    '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">' +
                    data[i].title + ' <small class="header">( <span>Header ' + level + '</span> )</small>' +
                    '<div class="btn-group btn-group-xs pull-right" role="group">' +
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
                ret += '<ol class="dd-list">' + tree(data[i].childs, (level + 1)) + '</ol>';
            }
            ret += '</li>';
        } else if (data[i].childs) {
            var data = tree(data[i].childs, (level));
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
        page_content = createTree(page_data, 2);
        if (!page_content) {
            page_content = '<div class="alert alert-warning">No Content in this page</div>';
        }
        var drag = $('#drag_content');
        $(drag).html(drag.html() + page_content);
    }
    $('.summernote').summernote({
        height: 100,
    });
    $('[data-toggle="tooltip"]').tooltip();
    $('#sm').delay(5000).fadeOut(500);
    var updateSortContent = function (e)
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
                success: function () {
                    location.reload();
                }
            });
        }
    };
    $('#drag_content').nestable().on('change', updateSortContent);
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
    }).on('keyup', '.friendly-url, .friendly-url-paste', function () {
        var friendly_url = $(this).val().toLowerCase().replace(/[^a-z\d\s\-]/g, '').replace(/[\s-]+/g, '-').trim();
        $('.friendly-url-paste').val(friendly_url);
        if ($('.friendly-url-full').length) {
            $('.friendly-url-full').text(URL + $('.friendly-url-paste').val());
        }
    }).on('keyup', '.search-page', function () {
        var ol = $(this).parent('ol');
        ol.find('li').hide();
        ol.find('li:contains(' + $(this).val() + ')').fadeIn();
    }).on('keyup', '', function () {
        if ($('.friendly-url-full').length) {
            $('.friendly-url-full').text(URL + $('.friendly-url-paste').val());
        }
    }).on('change', '.friendly-url-paste', function () {
        var friendly_url = $(this).val();
        friendly_url = friendly_url[friendly_url.length - 1] == '-' ? friendly_url.slice(0, friendly_url.length - 1) : friendly_url;
        $(this).val(friendly_url);
    });

    if ($('.friendly-url-full').length) {
        $('.friendly-url-full').text(URL + $('.friendly-url-paste').val());
    }


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
    });
    /*
     * menu js
     */
    var updateMenu = function ()
    {
        if (window.JSON) {
            var json_list = JSON.stringify($('#nestable').nestable('serialize'));
            json_list = JSON.parse(json_list);
            var recToArr = function rec(arr, data, parent = false) {
                var end = arr.length;
                for (var i = 0; i < end; i++) {
                    var current = data.length;
                    data[current] = {
                        'id': arr[i]['pageId'],
                        'page_id': arr[i]['pageId'],
                        'menu_id': (parent) ? parent : 0,
                        'sort': i
                    };
                    if (typeof arr[i]['children'] !== 'undefined' && arr[i]['children'] !== null) {
                        rec(arr[i]['children'], data, arr[i]['id']);
                    }
            }
            };
            var data = [];
            recToArr(json_list, data);
            $.ajax({
                url: URL + 'dashboard/CMS/menu/update',
                type: "PUT",
                dataType: "html",
                data: {'data': data},
                success: function () {
                    location.reload();
                }
            });
        }
    };
// activate Nestable for list 1
    $('#nestable').nestable({
        group: 1,
        maxDepth: 2
    }).on('change', updateMenu);
// activate Nestable for list 2
    $('#nestable2').nestable({
        group: 1,
        maxDepth: 1
    }).on('change', updateMenu);
});
$('.next').click(function () {

    var nextId = $(this).parents('.tab-pane').next().attr("id");
    $('[href=#' + nextId + ']').tab('show');
    return false;
})

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

//update progress
    var step = $(e.target).data('step');
    var percent = (parseInt(step) / 5) * 100;
    $('.progress-bar').css({width: percent + '%'});
    $('.progress-bar').text("Step " + step + " of 5");
    //e.relatedTarget // previous tab

});
$('.first').click(function () {

    $('#stepBar a:first').tab('show')

});

var addedImages = [];

if ($('#myDropzone').length) {
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("#myDropzone", {
        url: URL + "ajax/up",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        renameFile: true,
        addRemoveLinks: true,
        acceptedFiles: 'image/*',
        success: function (file, response) {
            file.serverFileName = response;
            addedImages.push(response);
            if (addedImages.length == 1) {
                var def = $('.dz-image > img[alt="' + file.name + '"]').parents('.dz-preview');
                $(def).prepend('<div class="label label-primary main-img">Default</div>');
                $('#def-img').val(file.name);
                $('#main_image').attr('src', URL + 'images/up/' + file.serverFileName);
            }
            $('#addedImages').val(JSON.stringify(addedImages)); //store array
        }
    });


    myDropzone.on("addedfile", function (file) {
        if ($('.dz-message').length) {
            $('.dz-message').hide();
        }
        if (file.serverFileName != null && file.serverFileName != undefined) {
            addedImages.push(file.serverFileName);
            $('#addedImages').val(JSON.stringify(addedImages)); //store array
        }
        $('.uploaded-img div.col-md-3').children('img[alt="' + file.serverFileName + '"]').remove();
        file.previewElement.addEventListener("click", function () {
            var image = $('.dz-image > img[alt="' + file.name + '"]').parents('.dz-preview');
            $('.main-img').remove();
            $(image).prepend('<div class="label label-primary main-img">Default</div>');
            $('#def-img').val(file.name);
            $('#main_image').attr('src', URL + 'images/up/' + file.serverFileName);
        });
    }).on("removedfile", function (file) {
        for (var i = 0, end = addedImages.length, run = true; run && i < end; i++) {
            if (addedImages[i] == file.serverFileName) {
                addedImages.splice(i, 1);
            }
        }
        if (addedImages.length == 0) {
            $('.dz-message').show();
            $('#def-img').val('');
            $('#main_image').attr('src', URL + 'images/empty.png');
        }
        $('#addedImages').val(JSON.stringify(addedImages)); //store array
    });

    $('.add-to-images').on('click', function () {
        if (addedImages.indexOf(this.alt) == -1) {
            var img = {name: this.alt, serverFileName: this.alt};
            myDropzone.emit("addedfile", img);
            myDropzone.emit("thumbnail", img, this.src);
            myDropzone.emit("complete", img);

            if (addedImages.length == 1) {
                var def = $('.dz-image > img[alt="' + this.alt + '"]').parents('.dz-preview');
                $(def).prepend('<div class="label label-primary main-img">Default</div>');
                $('#def-img').val(this.alt);
                $('#main_image').attr('src', URL + 'images/up/' + this.alt);
            }
        }
    });

    for (i = 0; i < existingFiles.length; i++) {
        myDropzone.emit("addedfile", existingFiles[i]);
        myDropzone.emit("thumbnail", existingFiles[i], URL + "images/up/" + existingFiles[i].name);
        myDropzone.emit("complete", existingFiles[i]);
    }

    var def = $('.dz-image > img[alt="' + def_img + '"]').parents('.dz-preview');
    $(def).prepend('<div class="label label-primary main-img">Default</div>');
    $('.show-images-btn').on('click', function () {
        $('.show-images').toggleClass('hidden');
        $(this).children('span').toggleClass('fa-plus-circle fa-minus-circle');
    });
}

if ($('#stock').length) {
    $('#stock').TouchSpin({
        verticalbuttons: true,
        prefix: 'qty',
        min: 0,
        max: 1000
    });
}
if ($('#price').length) {
    $('#price').TouchSpin({
        verticalbuttons: true,
        prefix: '$',
        step: 0.1,
        decimals: 2,
        boostat: 5,
        min: 1,
        max: 100000
    });
}

if ($('#sale').length) {
    $('#sale').TouchSpin({
        verticalbuttons: true,
        postfix: '%',
        step: 0.1,
        decimals: 2,
        boostat: 5,
        min: 0,
        max: 99
    });
}

if ($('.calc-price , .calc-sale').length) {
    $('.calc-price , .calc-sale').on('keyup', function () {
        var num = $('.calc-price').val() * (1 - ($('.calc-sale').val()) / 100);
        $('.calc-total').text('$' + num.toFixed(2));
    }).on('change', function () {
        var num = $('.calc-price').val() * (1 - ($('.calc-sale').val()) / 100);
        $('.calc-total').text('$' + num.toFixed(2));
    });
    var num = $('.calc-price').val() * (1 - ($('.calc-sale').val()) / 100);
    $('.calc-total').text('$' + num.toFixed(2));
}