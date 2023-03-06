<div class="x_content">
    <div class="dd" id="nestable-category" data-url="{{ route("admin.$controllerName.update_tree") }}">
        <ol class="dd-list">
            @foreach ($items as $item)
                @include("admin.pages.$controllerName.list-item", ['item' => $item, 'myLoop' => $loop])
            @endforeach
        </ol>
    </div>
</div>

<style>
    #nestable-category {
        max-width: 100%;
    }

    .category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: auto;
    }

    .category-item .area-action {
        display: flex;
        min-width: 300px;
    }

    .category-item .area-action > div {
        width: 50%;
    }

    .category-item .area-action > div:last-child {
        text-align: right;
    }

    .dd3-content {
        display: block;
        height: auto;
        margin: 5px 0;
        padding: 5px 10px 5px 40px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .dd3-content:hover {
        color: #2ea8e5;
        background: #fff;
    }

    .dd-dragel>.dd3-item>.dd3-content {
        margin: 0;
    }

    .dd3-item>button {
        margin-left: 30px;
        height: 40px;
    }

    .dd3-handle {
        position: absolute;
        height: 50px;
        margin: 0;
        left: 0;
        top: 0;
        cursor: pointer;
        width: 30px;
        text-indent: 30px;
        white-space: nowrap;
        overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background: linear-gradient(top, #ddd 0%, #bbb 100%);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .dd3-handle:before {
        content: '≡';
        display: block;
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        text-align: center;
        text-indent: 0;
        color: #fff;
        font-size: 20px;
        font-weight: normal;
    }

    .dd3-handle:hover {
        background: #ddd;
    }

</style>