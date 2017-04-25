#!/bin/bash

yesterday_str=$(date -d "yesterday" +%Y%m%d)
today_str=$(date -d "today" +%Y%m%d)
logpath=loghtml/${yesterday_str}.html

## 生成和插入数据
makelog(){
    if [ $# != 0 ];then
        date_str=$3
        loghtmlpath=loghtml/${date_str}.html
        goaccess $2 -a --html-report-title="世馨月子${date_str}日志" > ${loghtmlpath}
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
            goaccesspid=$(pgrep goaccess)
            if [ $goaccesspid != '' ];then
                kill -9 ${goaccesspid}
            fi
            goaccess /logfiles/10.116.47.240/access-${today_str}.log -o /wwwroot/goaccess-easyfrontend/loghtml/realtime.html --real-time-html --daemonize --html-report-title="世馨月子${today_str}实时日志"
        ;;
        *)
            if [[ $# == 3 ]];then
               makelog $1 $2 $3
            fi
            if [[ $#==2 && -f $1 ]];then
                makelog "1" $1 $2 
            fi
            if [[ $#==1 && -f $1 ]];then
                makelog "1" $1 ${yesterday_str} 
            fi
        ;;
    esac
fi

if [ $# -eq 0 ];then
    makelog "1" "/logfiles/10.116.47.240/access-${yesterday_str}.log" ${yesterday_str}  
    goaccesspid=$(pgrep goaccess)
    if [ $goaccesspid -ne '' ];then
        kill -9 ${goaccesspid}
    fi
    goaccess /logfiles/10.116.47.240/access-${today_str}.log -o /wwwroot/goaccess-easyfrontend/loghtml/realtime.html --real-time-html --daemonize --html-report-title="世馨月子${today_str}实时日志"
fi
