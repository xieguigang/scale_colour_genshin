require(JSON);

#' extract the image theme colors
#' 
#' @return a character vector of the theme color
#' 
extract_colors = function(file) {
    img = readImage(file);
    theme_colors = colors(img, n = 6, character = TRUE);
    rect = `<div style="width: 50px; height: 50px; background-color: ${theme_colors}"></div>`;
    rect = `
        <div style="width: 5%; min-width: 50px; float: left;">
            ${paste(rect, " ")}
        </div>
        <div style="width: 70%;">
            <img style="height: 600px;" src="${file}">
        </div>
    `;
    print(theme_colors);
    writeLines(rect, con = `${basename(file)}.html`);

    theme_colors;
}

pwd = @dir;
files = list.files(`${pwd}/character_posts/`, pattern = ".+\.((png)|(jpg))", wildcard = FALSE);
theme_colors = lapply(files, path -> extract_colors(path), names = basename(files));

print(basename(files));
str(theme_colors);

theme_colors
|> JSON::json_encode()
|> writeLines(con = `${pwd}/../data/scale_colour_genshin.json`)
;