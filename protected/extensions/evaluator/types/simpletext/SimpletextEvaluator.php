<?php

Yii::import("ext.evaluator.base.EvaluatorBase");

class SimpletextEvaluator extends EvaluatorBase {
    
    public function doEvaluate() {
        self::evaluate($this->submission);
    }

    public static function evaluate($submission) {
        if ($submission->contest !== null) {
            if (($submission->contest->contesttype->name == "ioi2010") && ($submission->contest->getConfig('secret'))) {
                $isSampleOnly = true;
                //return;
            }
        }

        $problems = $submission->problem->getConfig('problems');
        $answers = $submission->getSubmitContent('answers');
        $score = 0;
        $totalscore = 0;
        $count = count($problems);
        $grade_output = "";
        foreach ($problems as $k => $p) {
            echo sprintf(
                    "\t\t#%03d\n" .
                    "\t\t !! : %s\n" .
                    "\t\t ?? : %s\n", $k, str_replace('\n', '\n\t\t ', $p['answer']), $answers[$k]
            );

            if (str_replace(array(" ", "\n"), "", $p['answer']) == str_replace(array(" ", "\n"), "", $answers[$k])) {
                if (isset($p['point'])) {
                    $addedScore = $p['point'];
                } else {
                    $addedScore = 1;
                }
                $score += $addedScore;
                $grade_output .= sprintf("#%03d : %s", $k + 1, "Correct (Score : " . $addedScore . ")\n");
                $grade_output .= "\tAnswer:\n\t" . $answers[$k] . "\n";
                $grade_output .= "\tKey:\n\t" . $p['answer'] . "\n";
            } else {
                $foundalternative = false;
                if (isset($p['alternatives'])) {
                    $alternatives = $p['alternatives'];
                    $alt = 0;
                    foreach ($alternatives as $alternative) {
                        $alt++;
                        if (isset($alternative['answer']) && str_replace(array(" ", "\n"), "", $alternative['answer']) == str_replace(array(" ", "\n"), "", $answers[$k])) {
                            $foundalternative = true;
                            if (isset($alternative['point'])) {
                                $addedScore = $alternative['point'];
                            } else {
                                $addedScore = 1;
                            }
                            $score += $addedScore;
                            $grade_output .= sprintf("#%03d : Correct from alternative %d (Score : " . $addedScore . ")\n", $k + 1, $alt);
                            $grade_output .= "\tAnswer:\n\t" . $answers[$k] . "\n";
                            $grade_output .= "\tKey:\n\t" . $alternative['answer'] . "\n";
                            break;
                        }
                    }
                }
                if (!$foundalternative) {
                    $grade_output .= sprintf("#%03d : %s", $k + 1, "Incorrect (Score : 0)\n");
                }
            }
            $grade_output .= "------------------------------------------\n";
            if (isset($p['point'])) {
                $totalscore += $p['point'];
            } else {
                $$totalscore += 1;
            }
        }
        if ($count != 0) {
            $nscore = ($score / $count) * 100;
        } else {
            $nscore = 0;
        }

        if (!$isSampleOnly) {
            $submission->verdict = $score . "/" . $count;
            $submission->score = $score;
            $submission->setGradeContent("evaluator", $grade_output);
        } else {
            $submission->setGradeContent("official_result", $score);
            $submission->setGradeContent("official_output", $grade_output);
        }
    }

    public static function evaluatex($submission) {
        $problems = $submission->problem->getConfig('problems');
        $answers = $submission->getSubmitContent('answers');
        $score = 0;
        $totalscore = 0;
        $count = count($problems);
        $grade_output = "";
        foreach ($problems as $k => $p) {
            echo sprintf(
                    "\t\t#%03d\n" .
                    "\t\t !! : %s\n" .
                    "\t\t ?? : %s\n", $k, str_replace('\n', '\n\t\t ', $p['answer']), $answers[$k]
            );
            if (strcmp($p['answer'], $answers[$k]) == 0) {
                if (isset($p['point'])) {
                    $score += $p['point'];
                } else {
                    
                }
                $score += 1;
                $grade_output .= sprintf("#%03d : %s", $k, "Correct\n");
            } else {
                $grade_output .= sprintf("#%03d : %s", $k, "Incorrect\n");
            }
        }
        if ($count != 0) {
            $nscore = ($score / $count) * 100;
        } else {
            $nscore = 0;
        }
        $submission->verdict = $score . "/" . $count;
        $submission->score = $score;
        $submission->setGradeContent("evaluator", $grade_output);
    }

}
