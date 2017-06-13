library(edgeR);

# 基因表达量的输入文件格式要求有
# 
# ID	experiment1	experiment2	control1	control2
# gene1	expression1	expression2	expression3	expression4
# gene2	expression1	expression2	expression3	expression4
# gene3	expression1	expression2	expression3	expression4

# 运行edgeR进行DEG/DEP的计算分析
# @param table data.frame对象
run.edgeR <- function(table) {
	
	group <- factor(c(1,1,2,2)) # 分组变量 前两个为一组， 后一个为一组， 每个有两个重复
	y     <- DGEList(counts=table,group=group) # 构建基因表达列表
	y     <- calcNormFactors(y) # 计算样本内标准化因子
	y     <- estimateCommonDisp(y) #计算普通的离散度
	y     <- estimateTagwiseDisp(y) #计算基因间范围内的离散度
	et    <- exactTest(y) # 进行精确检验
	DEG   <- topTags(et) # 输出排名靠前的差异表达基因信息

	return(DEG);	
}

run.edgeR.csv <- function(table.csv) {
	table <- read.csv(table.csv); # 读取reads count文件
	table <- assign.Symbol(table);
	
	return(run.edgeR(table));
}

# 将dataframe的第一列的编号作为row的名称
assign.Symbol <- function(table) {
	Symbol <- names(table)[1];
	Symbol <- as.vector(table[, Symbol]);
	rownames(table) <- Symbol;
	
	return(table);
}

run.edgeR.tsv <- function(table.tsv) {
	table <- read.delim(table.tsv); # 读取reads count文件
	table <- assign.Symbol(table);
	
	return(run.edgeR(table));
}