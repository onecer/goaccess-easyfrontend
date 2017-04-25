#!/bin/bash

yesterday_str=$(date -d "yesterday" +%Y%m%d)
today_str=$(date -d "today" +%Y%m%d)
logpath=loghtml/${yesterday_str}.html

## 生成和插入数据
makelog(){
    if [ $# != 0 ];then
        date_str=$3
        loghtmlpath=loghtml/${date_str}.html
        goaccess $2 -a > ${loghtmlpath}
        logsize=$(stat -c "%s" $2)
        logsize_k=$(bc <<< "scale=2;${logsize}/1024")
        sql_str="insert into gef_infos(siteid,logdate,logsize,path) values($1,${date_str},${logsize_k},'${loghtmlpath}')"
        mysql -ushixin_logview -p<password>  shixin_logview -e "${sql_str}"
    fi
}

if [ $# != 0 ];then
    case $1 in
        all)
            loglist=$(find /logfiles/10.116.47.240/ -name "access*.log" | sort)
            for str in $loglist
            do
                ## yum 源安装的nginx 默认有日志分割并用gzip压缩，自行调整日志名或者代码
                logfile=${str%\.*}
                tmpdate=${logfile##*-}
#                gzip -d $str
                makelog 1 ${str} ${tmpdate}
#                rm -f ${logfile}
            done
        ;;
        realtime)
            goaccess access.log -o /wwwroot/goaccess-easyfrontend/loghtml/realtime.html --real-time-html
        ;;
        *)
            if [ $# == 3 ];then
               makelog $1 $2 $2
            fi
            if [ $#==2 && -f $1 ];then
                makelog $1 $2 ${yesterday_str} 
            fi
        ;;
    esac
fi
