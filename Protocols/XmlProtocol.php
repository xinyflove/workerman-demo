<?php
// Xml协议
/**
 * 协议定义
 * 	1.首部固定10个字节长度用来保存整个数据包长度，位数不够补0
 * 	2.数据格式为xml
 */
/**
 * 数据包样本
0000000121<?xml version="1.0" encoding="ISO-8859-1"?>
<request>
    <module>user</module>
    <action>getInfo</action>
</request>
 * 其中0000000121代表整个数据包长度，后面紧跟xml数据格式的包体内容
 */

namespace Protocols;
class XmlProtocol
{
    public static function input($recv_buffer)
    {
        if(strlen($recv_buffer) < 10)
        {
            // 不够10字节，返回0继续等待数据
            return 0;
        }
        // 返回包长，包长包含 头部数据长度+包体长度
        $total_len = base_convert(substr($recv_buffer, 0, 10), 10, 10);
        return $total_len;
    }

    public static function decode($recv_buffer)
    {
        // 请求包体
        $body = substr($recv_buffer, 10);
        // 把 XML 字符串载入对象中
        return simplexml_load_string($body);
    }

    public static function encode($xml_string)
    {
        // 包体+包头的长度
        $total_length = strlen($xml_string)+10;
        // 长度部分凑足10字节，位数不够补0
        $total_length_str = str_pad($total_length, 10, '0', STR_PAD_LEFT);
        // 返回数据
        return $total_length_str . $xml_string;
    }
}