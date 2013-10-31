function string.starts(String,Start)
    return string.sub(String,1,string.len(Start))==Start
end

function read_query( packet )
    if string.byte(packet) == proxy.COM_QUERY then
        local query = string.lower(string.sub(packet, 2))
        if string.starts(query, "alter") or string.starts(query, "create") or string.starts(query, "drop") then
            -- give your logfile a name, absolute path worked for me
            local log_file = '/var/log/mysql-proxy-ddl.log'
            local fh = io.open(log_file, "a+")
            fh:write( string.format("%s %6d -- \n %s \n",
                os.date('%Y-%m-%d %H:%M:%S'),
                proxy.connection.server["thread_id"],
                query))
            fh:flush()
        end
    end
end
