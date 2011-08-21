<?php

Object::add_extension("ModelAdmin", "ModelAdminBullkActionsDecorator");
ModelAdmin::$collection_controller_class = "ModelAdminBulkActions_CollectionController";

?>