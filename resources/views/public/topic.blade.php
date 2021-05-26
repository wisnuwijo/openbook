@extends('layouts.docs-public')

@section('title', $topic->name)
@section('topic-name', $topic->name)

@section('head')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/code@2.7.0/dist/bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/raw"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
@endsection

@section('content')
<div id="editorjs-public"></div>
@endsection

@section('aside-right')
<div class="table-of-content" style="position:fixed;right:0;width:250px;padding:10px;"></div>
@endsection

@section('js')
<script>
// part 1. table of content
function generateTableOfContent() {
    $('.table-of-content').empty();

    var element = `
        <b>Table of contents</b>
        <ul>
    `;
    $('h1, h2, h3, h4, h5, h6').each(function (index) {
        var elementId = 'heading-' + index;

        $(this).attr('id', elementId);
        element += `<li onclick="scrollToHeading('${elementId}')" style="cursor:pointer">` + $(this).text() + `</li>`;
    });

    element += '</ul>';

    $('.table-of-content').append(element);
}

function scrollToHeading(id) {
    $('html, body').animate({
        scrollTop: $("#" + id).offset().top
    }, 1700);
}
</script>

<script>
// part 2. show editor
let activePageId = 0;
let activePageData = {};

var editor = new EditorJS({
    holder: 'editorjs-public',
    autofocus: true,
    readOnly: true,
    tools: {
        image: SimpleImage,
        code: CodeTool,
        warning: Warning,
        raw: RawTool,
        table: {
            class: Table,
        },
        header: {
            class: Header,
            inlineToolbar: true
        },
        list: List
    },
    data: activePageData,
    onChange: () => {}
});

function refreshContent(activePageId) {
    axios.get('{{ url("/public-api/breakdown-content") }}', {
        params: {
            'breakdown_url': activePageId
        }
    })
    .then(res => {
        try {
            activePageData = JSON.parse(res.data.data.content);
        } catch (error) {
            activePageData = {
                blocks: []
            };
        }

        if (activePageData.blocks.length <= 0) {
            activePageData = {"time":1619585697328,"blocks":[{"type":"paragraph","data":{"text":""}}],"version":"2.20.2"};
        }

        activePageData.active_page_id = activePageId;

        editor.isReady.then(() => {
            // only show breakdown that doesn't have children
            initialBlocks = activePageData;

            editor.render(activePageData);
        })
    });
}

window.addEventListener("hashchange", function () {
    let currHash = location.hash.substring(1).split('-');

    activePageId = currHash[0];

    refreshContent(activePageId);
    setTimeout(function () {
        generateTableOfContent();
    }, 1000);
});
</script>

<script>
// part 3. sidebar configuration
var sidebar = {
    getBreakdownFromApi: function () {
        var latestVersionId = $('.version').val(),
            topicId = '{{ $topic->id }}',
            url = '{{ url("/public-api/breakdown/get") }}' + '?topic_id=' + topicId + '&version_id=' + latestVersionId;

        // fetch doesn't support string query
        var data = fetch(url)
            .then(response => response.json());

        return data;
    },
    convertBreakdownDataToSidebar: function (breakdown) {
        var breakdownElement = '';
        for (var i = 0;i < breakdown.length; i++) {
            var currElement = breakdown[i];

            var hasChildren = currElement.children.length > 0;

            breakdownElement += `<li breakdown-id="${currElement.id}" class="${hasChildren ? "sidebar-dropdown" : ""}">`;
            breakdownElement += `<a breakdown-id="${currElement.id}" has-children=${hasChildren ? 1 : 0} href="#${currElement.link}"><span class="menu-text">${currElement.name}</span></a>`;            
            if (hasChildren) {
                breakdownElement += `<div parent-id="${currElement.id}" class="sidebar-submenu" style="display:none;">`;
                breakdownElement += `<ul>`;
                
                for (var j = 0;j < currElement.children.length;j++) {
                    var currChild = currElement.children[j];
                
                    breakdownElement += `<li><a breakdown-id="${currChild.id}" parent-id="${currElement.id}" is-child="1" href="#${currChild.link}">${currChild.name}</a></li>`;
                }

                breakdownElement += `</ul>`;
                breakdownElement += `</div>`;
            }
            breakdownElement += `</li>`;            
        }
        
        return breakdownElement;
    },
    implementBreakdownElement: function (breakdownElement) {
        $('.docs-sidebar')
            .empty()
            .append(breakdownElement);
    },
    generate: function () {
        sidebar.getBreakdownFromApi()
            .then(data => {
                var breakdownElement = sidebar.convertBreakdownDataToSidebar(data.breakdown);
                sidebar.implementBreakdownElement(breakdownElement);
            });
    }
};

$(function () {
    let currHash = location.hash.substring(1).split('-');
    activePageId = currHash[0];

    refreshContent(activePageId);
    setTimeout(function () {
        generateTableOfContent();
    }, 1000);

    sidebar.generate();
})

$('.version').change(function (e) {
    sidebar.generate();
})

var activeBreakdownId = '0';
$(document).on('click','a', function(){
    var hasChildren = $(this).attr('has-children'),
        breakdownId = $(this).attr('breakdown-id'),
        isChild = $(this).attr('is-child') == "1",
        parentId = $(this).attr('parent-id'),
        isMenuActive = $('li[breakdown-id='+ activeBreakdownId +']').hasClass('active');

    // remove bold from previous child
    if (breakdownId != activeBreakdownId) {
        $('a[breakdown-id='+ activeBreakdownId +']').css('font-weight','normal');
    } else {
        var currentFontWeight = $('a[breakdown-id='+ activeBreakdownId +']').css('font-weight'),
            isFontWeightNormal = currentFontWeight == 400;

        if (isFontWeightNormal) {
            $('a[breakdown-id='+ breakdownId +']').css('font-weight','bold');
            activeBreakdownId = breakdownId;

            return;
        }
    }

    if (isChild) {
        // add bold to new active child
        $(this).css('font-weight','bold');
        
        activeBreakdownId = breakdownId;
        return;
    }

    if (activeBreakdownId != '0') {
        // remove previous breakdown active class
        $('li[breakdown-id='+ activeBreakdownId +']').removeClass('active');
        $('div[parent-id='+ activeBreakdownId +']').slideUp();
    }
    
    if (isMenuActive) {
        // active menu is click again
        // action : deactivate menu
        $(this).css('font-weight','normal');

        $('li[breakdown-id='+ activeBreakdownId +']').removeClass('active');
        $('div[parent-id='+ activeBreakdownId +']').slideUp();
    } else {
        // add active class to current selected breakdown
        $(this).css('font-weight','bold');

        $('li[breakdown-id='+ breakdownId +']').addClass('active');
        $('div[parent-id='+ breakdownId +']').slideDown(200);
    }

    activeBreakdownId = breakdownId;
});
</script>
@endsection