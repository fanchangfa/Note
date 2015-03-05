```
git add			#把要提交的所有修改放到暂存区（Stage）
```
```
git commit		#把暂存区的所有修改提交到分支
```
```
git init
```
```
git branch
```
```
git branch -b
```
```
git branch -d
git branch -D dev1		#若在新分支dev1的内容没被合并，需要用此方法来强制删除
```
```
git checkout
```
```
git log
git log --pretty=oneline	#一行显示每个版本,commit_id包含在前几位
```
#### 版本回退：
	HEAD表示当前版本(指针指向当前版本)，Head^上一个版本，HEAD^^上上个版本，HEAD~100第前100个版本
	git reset --hard HEAD^	#回退到上个版本
	git reset --hard 12345	#回退到commit_id为12345的版本

```
git reflog	#查看每一次操作的git命令
```

Git的版本库里存了很多东西，其中最重要的就是称为stage（或者叫index）的暂存区，还有Git为我们自动创建的第一个分支master，以及指向master的一个指针叫HEAD。
```
git diff HEAD -- readme.txt 	#查看工作区和版本库里面最新版本的区别

git checkout -- readme.txt		#丢弃工作区的修改,回到最近一次git commit或git add时的状态
git reset HEAD file 			#把暂存区的修改撤销掉（unstage），重新放回工作区
```

场景1：当你改乱了工作区某个文件的内容，想直接丢弃工作区的修改时，用命令git checkout -- file。

场景2：当你不但改乱了工作区某个文件的内容，还添加到了暂存区时，想丢弃修改，分两步，第一步用命令git reset HEAD file，就回到了场景1，第二步按场景1操作。

#### 删除文件：
	用命令 rm test.txt 删除后，
	1. git rm test.txt 从版本库中删除
	2. git checkout -- test.txt 取消删除
```
	git rm用于删除一个文件。如果一个文件已经被提交到版本库，那么你永远不用担心误删，但是要小心，你只能恢复文件到最新版本，你会丢失最近一次提交后你修改的内容。
```

#### 远程仓库:
	1. ssh -keygen -C "emailaddress@example.com";	#在目录~/.ssh/下生成 id_rsa 和 id_rsa.pub
	2. 在github的Account Setting中将id_rsa.pub内容加进去

	关联本地和远程库:
		git remote add origin git@github.com:用户名/仓库名.git
	推送本地库内容到远程库:
		git push -u origin master
		```#不但会把本地的master分支内容推送的远程新的master分支，还会把本地的master分支和远程的master分支关联起来
		```
		git push					#把当前分支master推送到远程
		git push origin master		#把本地master分支的最新修改推送至GitHub (也可推送其他分支)

	从远程库克隆:
		git clone 远程库地址
	
#### 合并分支:
	git merge dev	#当前在master分支中执行此命令，即将dev分支的修改合并到master

	通常，合并分支时，如果可能，Git会用Fast forward模式，但这种模式下，删除分支后，会丢掉分支信息。
	合并分支时，加上--no-ff参数就可以用普通模式合并，合并后的历史有分支，能看出来曾经做过合并，而fast forward合并就看不出来曾经做过合并。

	git merge --no-ff -m "merge with no-ff" dev
	git log --graph --pretty=oneline --abbrev-commit	#可以看出曾经做过合并

#### bug分支:
	git stash	#将当前分支进行现场保护，此时git status是干净的
	在master创建bug分支，完成后merge到master，在切回来原来分支
	git stash list	#查看已存储起来的分支
	##### 恢复现场：
		1. git stash apply	#恢复后stash内容没删除
		   git stash drop 	#删除stash内容
		2.git stash pop		#恢复同时删除stash内容

		git stash apply stash@{0}		恢复指定stash

#### 冲突:
	git checkout -b dev origin/dev	#创建本地dev分支，从远程origin的dev分支到本地
	第一个人提交了文件
	此时提交相同文件会发生冲突
	git pull	#把最新的提交从origin/dev获取下来
	若git pull失败，原因是没有指定本地dev分支与远程origin/dev分支的链接:
		git branch --set-upstream dev origin/dev
	再次pull,解决后提交
