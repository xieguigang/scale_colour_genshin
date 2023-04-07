const __get_inmemory_cache = function() {
    const env = globalenv();
    const get_data = get("scale_colours@genshin", env);

    as.list(get_data);
}