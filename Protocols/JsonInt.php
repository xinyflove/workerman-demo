<?php
// 
/**
 * 协议定义
 * 	1.首部4字节网络字节序unsigned int，标记整个包的长度
 * 	2.数据部分为Json字符串
 */
/**
 * 数据包样本
****{"type":"message","content":"hello all"}
 * 其中首部四字节*号代表一个网络字节序的unsigned int数据，为不可见字符，紧接着是Json的数据格式的包体数据
 */
namespace Protocols;
class JsonInt
{
    public static function input($recv_buffer)
    {
        // 接收到的数据还不够4字节，无法得知包的长度，返回0继续等待数据
        if(strlen($recv_buffer)<4)
        {
            return 0;
        }
        // 利用unpack函数将首部4字节转换成数字，首部4字节即为整个数据包长度
        $unpack_data = unpack('Ntotal_length', $recv_buffer);
        return $unpack_data['total_length'];
    }

    public static function decode($recv_buffer)
    {
        // 去掉首部4字节，得到包体Json数据
        $body_json_str = substr($recv_buffer, 4);
        // json解码
        return json_decode($body_json_str, true);
    }

    public static function encode($data)
    {
        // Json编码得到包体
        $body_json_str = json_encode($data);
        // 计算整个包的长度，首部4字节+包体字节数
        $total_length = 4 + strlen($body_json_str);
        // 返回打包的数据
        return pack('N',$total_length) . $body_json_str;
    }
}