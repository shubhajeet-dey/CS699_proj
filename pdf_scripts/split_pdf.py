#!/usr/bin/env python3
from PyPDF2 import PdfWriter, PdfReader
from zipfile import ZipFile 
import os
import uuid

# Splitting the main pdf into subpdfs at split_points
def split_pdf(file_name, split_points):
	
	# Getting directory values from environment variables
	upload_path = os.environ.get('UPLOAD_FILES_PATH', '../uploads')
	temp_path = os.environ.get('TEMP_FILES_PATH', '../temp')
	result_path = os.environ.get('FINAL_FILES_PATH', '../final_results')

	reader = PdfReader(os.path.join(upload_path, file_name))
	cnt = 0
	writer = PdfWriter()
	splitted_file_names = []

	# Spliting pdf in multiple pdfs
	for page_num in range(len(reader.pages)):
		writer.add_page(reader.pages[page_num])
		if cnt < len(split_points) and (page_num + 1) == split_points[cnt]:
			cnt = cnt + 1
			splitted_file_names.append(os.path.join(temp_path, file_name + "_" + str(cnt) + "_" + str(uuid.uuid4()) + ".pdf"))
			writer.write(splitted_file_names[-1])
			writer.close()
			writer = PdfWriter()
	
	# Writing the remaining pages
	cnt = cnt + 1
	splitted_file_names.append(os.path.join(temp_path, file_name + "_" + str(cnt) + "_" + str(uuid.uuid4()) + ".pdf"))
	writer.write(splitted_file_names[-1])
	writer.close()

	# Zipping all the generated PDFS
	zip_file_name = file_name + '_' + str(uuid.uuid4()) + ".zip"
	with ZipFile(os.path.join(result_path, zip_file_name),'w') as zip:  
		for file in splitted_file_names: 
			zip.write(file, os.path.basename(file))

	# Removing Temporary files
	for file in splitted_file_names:
		os.remove(file)

	return zip_file_name
	