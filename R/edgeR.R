run.DEP <- function(table) {

	x     <- read.delim("fileofcounts.txt", row.names="Symbol") # 读取reads count文件
	group <- factor(c(1,1,2,2)) # 分组变量 前两个为一组， 后一个为一组， 每个有两个重复
	y     <- DGEList(counts=x,group=group) # 构建基因表达列表
	y     <- calcNormFactors(y) # 计算样本内标准化因子
	y     <- estimateCommonDisp(y) #计算普通的离散度
	y     <- estimateTagwiseDisp(y) #计算基因间范围内的离散度
	et    <- exactTest(y) # 进行精确检验
	DEP   <- topTags(et) # 输出排名靠前的差异表达基因信息

	return(DEP);	
}

