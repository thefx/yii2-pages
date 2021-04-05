<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tree array */

use thefx\pages\assets\JsTree\JsTreeAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;

JsTreeAsset::register($this);

$this->registerJs('

    var treeData = ' . json_encode($tree) . ';

	var tree = $("#tree").jstree({
		"core" : {
            "data" : treeData,
            "check_callback" : true,
		},
        "plugins" : [ "contextmenu" , "state", "dnd" ],
		"state" : { "key" : "pages" },
		"contextmenu":{
            "items": function(node) {
                var tree = $("#frmt").jstree(true);
                return {
                    "Create": {
                        "separator_before": false,
                        "separator_after": false,
                        "label": "Добавить",
                        "icon": "fas fa-plus text-success",
                        "action": function (obj) {
//                            console.log(node.original.id);
                            window.location.href = "/pages/default/create?parent_id=" + node.original.id;
                        }
                    },
                    "Edit": {
                        "separator_before": false,
                        "separator_after": false,
                        "label": "Редактировать",
                        "icon": "fas fa-pencil-alt",
                        "action": function (obj) {
                             window.location.href = "/pages/default/update?id=" + node.original.id;
                        }
                    },                         
                    "Remove": {
                        "separator_before": false,
                        "separator_after": false,
                        "label": "Удалить",
                        "icon": "fas fa-trash text-danger",
                        "action": function (obj) {
                            var r = confirm("Удалить страницу?");
                            
                            if (r == true)
                            $.ajax({
                                url: "/pages/default/delete?id=" + node.original.id,
                                type: "post",
                                data: {id:node.original.section_id}
                                }).done(function() {
                                window.location.href = "/admin/pages";
                            });
                        }
                    }
                };
            }
        }
	})
	.bind("create.jstree", function (e, data) {
	    console.log(data);
    })
    .bind("move_node.jstree", function(e, data) {

       $(".overlay").removeClass("hide");

        var url = "' . Url::to(['tree-move']) . '";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                ajax: true,
                id: data.node.id,
//                type: data.node.type,
                parent: data.parent,
                old_parent: data.old_parent,
                position: data.position,
                old_position: data.old_position,
            },
            dataType: "json"
        }).done(function(data){
//            console.log(data);
            tree.jstree(true).settings.core.data = data;
            tree.jstree(true).refresh();
//       tree.jstree("refresh");
        }).fail(function() {
            window.location.reload();
        }).always(function() {
           $(".overlay").addClass("hide");
        });

    });'

    , View::POS_READY);
?>

<div class="pages-index">

    <p>
        <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div id="tree"></div>

</div>
