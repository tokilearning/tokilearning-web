<?php
/**
 *
 * @param Submission_Model $submission
 * @param object $post
 * @return success
 */
function submit($submission)
{
    if ($_FILES['Submission']['error']['submissionfile'] != UPLOAD_ERR_OK) 
		throw new Exception("Upload failed");
    
	$sourcefilename = $_FILES['Submission']['name']['submissionfile'];
    $filetype = CSourceHelper::getSourceExtension($sourcefilename);
    if ($filetype == null) 
		throw new Exception("Unknown file type");
		
    $filecontent = file_get_contents($_FILES['Submission']['tmp_name']['submissionfile']);
    $submission->setSubmitContent('source_lang', $filetype);
    $submission->setSubmitContent('original_name', $sourcefilename);
    $submission->setSubmitContent('source_content', $filecontent);
    return true;
}

/**
 *
 * @param $post
 */
function config($problem, $config)
{
    $problem->setConfig('time_limit', $config['time_limit']);
    $problem->setConfig('memory_limit', $config['memory_limit']);
    $testcases = array();
    if (isset($config['testcases']))
    {
        ksort(&$config['testcases']);
        foreach($config['testcases'] as $val)
        {
            $testcases[] = $val;
        }
    }
    $problem->setConfig('testcases', $testcases);
    $problem->save();
    return true;
}
//end of file