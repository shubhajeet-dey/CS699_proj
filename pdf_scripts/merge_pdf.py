#!/usr/bin/env python3
from PyPDF2 import PdfWriter
import os
import uuid

# Merging PDFs using PyPDF2 library
def merge_pdf(file_names):
	
	# Getting directory values from environment variables
	upload_path = os.environ.get('UPLOAD_FILES_PATH', '../uploads')
	temp_path = os.environ.get('TEMP_FILES_PATH', '../temp')
	result_path = os.environ.get('FINAL_FILES_PATH', '../final_results')

	# Creating a PDF writer object for the output file
	merge_pdf_ = PdfWriter()

	# Merging the files
	for file in file_names:
		merge_pdf_.append(os.path.join(upload_path, file))

	# Creating the merge PDF file
	merge_file_name = "merge_" + str(uuid.uuid4()) + ".pdf"
	merge_pdf_.write(os.path.join(result_path, merge_file_name))
	merge_pdf_.close()

	# Returning merged file name
	return merge_file_name
