#!/bin/bash

yesterday_str=$(date -d "yesterday" +%Y%m%d)
logpath=loghtml/${yesterday_str}.html

## 生成和插入数据
makelog(){
    if [ $# != 0 ];then
        date_str=$2
        loghtmlpath=loghtml/${date_str}.html
        goaccess $1 -a > ${loghtmlpath}
        logsize=$(stat -c "%s" $1)
        logsize_k=$(bc <<< "scale=2;${logsize}/1024")
        sql_str="insert into gef_infos(logdate,logsize,path) values(${date_str},${logsize_k},'${loghtmlpath}')"
        mysql -ushixin_logview -p<password>  shixin_logview -e "${sql_str}"
    fi
}

if [ $# != 0 ];then
    case $1 in
        all)
            loglist=$(find /var/log/nginx/ -name "access*.gz" | sort)
            for str in $loglist
            do
                ## yum 源安装的nginx 默认有日志分割并用gzip压缩，自行调整日志名或者代码
                logfile=${str%\.*}
                tmpdate=${logfile##*-}
                gzip -d $str
                makelog ${logfile} ${tmpdate}
                rm -f ${logfile}
            done
        ;;
        *)
            if [ $# == 2 ];then
               makelog $1 $2 
            fi
            if [ $#==1 && -f $1 ];then
                makelog $1 ${yesterday_str} 
            fi
        ;;
    esac
fi
