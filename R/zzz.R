require(ggplot);
require(JSON);

const .onLoad = function() {
    const env = globalenv();
    const palette = "data/scale_colour_genshin.json" 
    |> system.files(package = "scale_colour_genshin")
    |> readText()
    |> JSON::json_decode()
    ;

    set(env, "scale_colours@genshin", palette);
}