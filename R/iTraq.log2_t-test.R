library(tools) 

logFC.test.csv <- function(data.csv, level = 1.5, p.value = 0.05) {
	logFC.test(read.csv(data.csv), level, p.value);
}

logFC.test.tsv <- function(data.txt, level = 1.5, p.value = 0.05) {
	logFC.test(read.delim(data.txt), level, p.value);
}

# 判断目标向量vector之中的所有的元素是否都等于元素x？
ALL.Equals <- function(vector, x) {
    nna <- which(!is.na(vector));
	v   <- which(vector==x);
	l   <- length(vector);
	return(l == length(v) && l == length(nna));
}

### iTraq结果的差异表达蛋白的检验计算
### 在这个函数之中，输入的表格文件的第一列为蛋白质的id编号，剩下的所有的列都是一个实验设计的比值结果
### 通过与等长的零向量做比较来通过假设检验判断是否是差异表达的？
### @level: 蛋白组分析之中的差异表达的阈值默认为log2(1.5)，对于转录组而言，这里是log2(2) = 1
###         如果信号量的变化值都比较低，可以考虑level参数值取值1.25
logFC.test <- function(data, level = 1.5, p.value = 0.05) {
	
	repeatsNumber = ncol(data) - 1          # 实验重复数
	ZERO          = rep(0, repeatsNumber)   # 得到等长的进行比较的0向量
	index         = seq(2, repeatsNumber+1)
	pvalue        = rep(0, nrow(data))
	avgFC         = rep(0, nrow(data))

	# 对dataframe之中的每一行都进行计算
	for(i in 1:(nrow(data))) {
		
		row    = data[i, ]
		# 得到FC向量
		v      = as.vector(as.matrix(row[index]))
		valids = sum(!is.na(v))

		if (ALL.Equals(v, 0)) {
		
			# 所有的值都是0的话，是无法进行假设检验的
			# 可能是上游的计算错误，在这里全部置为无效
			avgFC[i]  <- NA;
			pvalue[i] <- NA;
			
		} else if (valids > 0) {
		
			v = v[!is.na(v)]
			l = repeatsNumber - length(v)
			# 使用1补齐NA
			v = as.vector(append(v, rep(1, l)))  
			avgFC[i] = mean(v, na.rm = TRUE)
			avgFC[i]
			v = log(v, 2)
			# log2(FC) 结果和等长零向量做检验得到pvalue
			pvalue[i] = t.test(v, ZERO, var.equal = TRUE)$p.value	
			
		} else {
			avgFC[i]  <- NA;
			pvalue[i] <- NA;
		}
	} 
	
	data["FC.avg"]  = avgFC
	data["p.value"] = pvalue
	
	# DEP 计算结果	
	downLevel      = 1 / level;
	data["is.DEP"] = ((avgFC >= level | avgFC <= downLevel) & (pvalue <= p.value))
	
	DIR <- dirname(file);
	DIR <- paste(DIR, file_path_sans_ext(basename(file)), sep="/");
	out <- paste(DIR, "-avgFC-log2-t.test.csv", sep="");
	
	write.csv(data, out, row.names= FALSE)
}