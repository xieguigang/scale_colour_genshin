require(JSON);

#' extract the image theme colors
#' 
#' @return a character vector of the theme color
#' 
extract_colors = function(file) {
    img = readImage(file);
    theme_colors = colors(img, n = 6, character = TRUE);
    rect = `<div style="width: 100px; height: 25px; background-color: ${theme_colors}">
				<span style="color: white;">&nbsp;&nbsp;${theme_colors}</span>
			</div>`;
    rect = `
        <div style="width: 10%; min-width: 100px; float: left;">
            ${paste(rect, " ")}
        </div>
        <div style="width: 70%;">
            <img style="height: 600px;" src="./../character_posts/${basename(file, withExtensionName = TRUE)}">
        </div>
    `;
    print(theme_colors);
    writeLines(rect, con = `${pwd}/demo/${basename(file)}.html`);

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