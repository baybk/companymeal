<?php

use App\Http\Contract\UserBusinessClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

if (!function_exists('transChoiceHp')) {
    function transChoiceHp($transCode, $choiceNum = 1)
    {
        return trans_choice($transCode, $choiceNum);
    }
}

if (!function_exists('generateNewCode')) {
    function generateNewCode()
    {
        $salt = Str::random(20);
        $timestamp = Carbon::now()->timestamp;
        $code = $salt . '_' . $timestamp;
        return $code;
    }
}

if (!function_exists('isAdminUserHelper')) {
    function isAdminUserHelper()
    {
        return (new UserBusinessClass())->isAdminUserHelper();
    }
}

if (!function_exists('getCurrentTeamHelper')) {
    function getCurrentTeamHelper()
    {
        return (new UserBusinessClass())->getCurrentTeam();
    }
}

if (!function_exists('transOrderKey')) {
    function transOrderKey($key)
    {
        $listTrans = [
            'customer_name' => 'Tên khách hàng',
            'customer_phone' => 'Số điện thoại',
            'customer_address' => 'Địa chỉ',
            'productName' => 'Tên sản phẩm',
            'quantity' => 'Số lượng mua',
            'price' => 'Đơn giá',
            'note' => 'Ghi chú',
            'link' => 'Link sản phẩm',
            'manager_link' => 'Link quản lí',
            'total_price' => 'Tổng tiền hàng dự kiến'
        ];
        if (array_key_exists($key, $listTrans)) {
            return $listTrans[$key];
        }
        return $key;
    }
}

if (!function_exists('getAppUrl')) {
    function getAppUrl()
    {
        if (env('APP_ENV') != 'local') {
            return env('APP_URL');
        } else {
            return 'http://localhost:8888';
        }
    }
}

if (!function_exists('currentAdminOrderDeliveryStatus')) {
    function currentAdminOrderDeliveryStatus($originDeliveryStatus)
    {
        $status = '';
        switch ($originDeliveryStatus) {
            case DELIVERY_STATUS_REQUEST:
                $status = 'Chưa xử lí';
                break;
            case DELIVERY_STATUS_CANCELED:
                $status = 'Đã huỷ';
                break;
            case DELIVERY_STATUS_CONFIRMED:
                $status = 'Đã xác nhận xử lí';
                break;
            case DELIVERY_STATUS_DELIVERING:
                $status = 'Đang giao hàng';
                break;
            case DELIVERY_STATUS_DELIVERED:
                $status = 'Đã giao hàng';
                break;
            case DELIVERY_STATUS_PENDING:
                $status = 'Tạm hoãn xử lí';
                break;
            default:
                $status = 'Chưa xử lí';
                break;
        }
        return $status;
    }
}

if (!function_exists('cssClassDeliveryStatus')) {
    function cssClassDeliveryStatus($deliveryStatus)
    {
        $className = '';
        switch ($deliveryStatus) {
            case DELIVERY_STATUS_REQUEST:
                $className = 'order-request';
                break;
            case DELIVERY_STATUS_CANCELED:
                $className = 'order-canceled';
                break;
            case DELIVERY_STATUS_CONFIRMED:
                $className = 'order-confirmed';
                break;
            case DELIVERY_STATUS_DELIVERING:
                $className = 'order-delivering';
                break;
            case DELIVERY_STATUS_DELIVERED:
                $className = 'order-delivered';
                break;
            case DELIVERY_STATUS_PENDING:
                $className = 'order-pending';
                break;
            default:
                $className = 'order-request';
                break;
        }
        return $className;
    }
}

if (!function_exists('getProperNextDeliveryOrderStatuses')) {
    function getProperNextDeliveryOrderStatuses($currentStatus)
    {
        $nextStatusList = [];
        switch ($currentStatus) {
            case DELIVERY_STATUS_REQUEST:
                $nextStatusList = [
                    DELIVERY_STATUS_CONFIRMED,
                    DELIVERY_STATUS_PENDING,
                    DELIVERY_STATUS_DELIVERING,
                    DELIVERY_STATUS_CANCELED,
                ];
                break;
            case DELIVERY_STATUS_PENDING:
                $nextStatusList = [
                    DELIVERY_STATUS_CONFIRMED,
                    DELIVERY_STATUS_DELIVERING,
                    DELIVERY_STATUS_CANCELED,
                ];
                break;
            case DELIVERY_STATUS_CONFIRMED:
                $nextStatusList = [
                    DELIVERY_STATUS_PENDING,
                    DELIVERY_STATUS_DELIVERING,
                    DELIVERY_STATUS_DELIVERED,
                    DELIVERY_STATUS_CANCELED,
                ];
                break;
            case DELIVERY_STATUS_DELIVERING:
                $nextStatusList = [
                    DELIVERY_STATUS_DELIVERED,
                    DELIVERY_STATUS_PENDING,
                    DELIVERY_STATUS_CANCELED,
                ];
                break;
            case DELIVERY_STATUS_DELIVERED:
                $nextStatusList = [
                ];
                break;
            default:
                $nextStatusList = [
                ];
                break;
        }
        return $nextStatusList;
    }
}
