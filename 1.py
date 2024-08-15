import os
import re

# 获取当前脚本所在的目录
current_directory = os.path.dirname(os.path.abspath(__file__))

# 用于存储提取结果的列表
results = []

# 遍历当前目录下的所有子文件夹
for folder_name in os.listdir(current_directory):
    folder_path = os.path.join(current_directory, folder_name)
    
    # 检查是否是文件夹，并且其中包含 index.php 文件
    if os.path.isdir(folder_path) and 'index.php' in os.listdir(folder_path):
        index_path = os.path.join(folder_path, 'index.php')
        
        # 打开并读取 index.php 文件内容
        with open(index_path, 'r', encoding='utf-8') as file:
            content = file.read()
            
            # 使用正则表达式查找注释中的考点信息
            match = re.search(r'---\s*HelloCTF\s*-\s*RCE靶场\s*关卡\s*(\d+)\s*:\s*(.*)\s*---', content)
            if match:
                level = match.group(1)  # 提取关卡编号
                topic = match.group(2)  # 提取考点
                results.append(f'Level {level} : {topic}')

# 将结果按关卡编号排序后输出
for result in sorted(results):
    print(result)
