extract_colors = function(file) {
    img = readImage(file);
    theme_colors = colors(img, n = 6,character  = TRUE);
    rect = `<div style="width: 50px; height: 50px; background-color: ${theme_colors}"></div>`;
    rect = `
        <div style="width: 5%; min-width: 50px; float: left;">
        ${paste(rect, " ")}
        </div>
        <div style="width: 70%;"><img style="height: 600px;" src="${file}"></div>
    `;
    print(theme_colors);
    writeLines(rect, con = `${basename(file)}.html`);
}

pwd = @dir;
files = list.files(`${pwd}/character_posts/`, pattern = ".+\.((png)|(jpg))", wildcard = FALSE);

print(basename(files));