<?php

function convertStatus($status) {
    switch ($status) {
        case 0: {
            return "<span class='label label-warning radius'>待审核</span>";
        }
        case 1: {
            return "<span class='label label-success radius'>正常</span>";
        }
        case -1: {
            return "<span class='label label-danger radius'>弃用</span>";
        }
        default: {
            return "<span class='label label-danger radius'>状态异常</span>";
        }
    }
}
