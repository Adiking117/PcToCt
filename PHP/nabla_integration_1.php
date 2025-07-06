<!DOCTYPE html>
<html>
<head>
    <title>Nabla SOAP Note Integration</title>
    <script>
        function parseSOAP(text) {
            const regex = /Subjective\s*([\s\S]*?)\s*Objective\s*([\s\S]*?)\s*Assessment\s*([\s\S]*?)\s*Plan\s*([\s\S]*)/i;
            const match = text.match(regex);
            if (match) {
                return {
                    subjective: match[1].trim(),
                    objective: match[2].trim(),
                    assessment: match[3].trim(),
                    plan: match[4].trim()
                };
            }
            return null;
        }

        document.addEventListener("DOMContentLoaded", function () {
            const subjectiveField = document.getElementById("subjective");
            const objectiveField = document.getElementById("objective");
            const assessmentField = document.getElementById("assessment");
            const planField = document.getElementById("plan");

            let populated = false;
            let intervalId = setInterval(async () => {
                if (populated) return;
                try {
                    const text = await navigator.clipboard.readText();
                    if (text.startsWith("Subjective")) {
                        const soap = parseSOAP(text);
                        if (soap) {
                            subjectiveField.value = soap.subjective;
                            objectiveField.value = soap.objective;
                            assessmentField.value = soap.assessment;
                            planField.value = soap.plan;
                            populated = true;
                            clearInterval(intervalId); // Stop polling

                            // Erase clipboard content
                            try {
                                await navigator.clipboard.writeText("");
                            } catch (err) {
                                // Clipboard write may fail if not allowed by browser
                                console.warn("Could not clear clipboard.", err);
                            }
                        }
                    }
                } catch (err) {
                    // fail silently
                }
            }, 2000);
        });
    </script>
</head>
<body>
    <h2>🩺 Nabla Note Capture</h2>
    <button onclick="alert('Now activate the Nabla extension and use Copy!')">
        🔊 Invoke Nabla
    </button>
    <br><br>
    <label for="subjective"><b>Subjective:</b></label><br>
    <textarea id="subjective" rows="4" cols="80" placeholder="Waiting for 'Subjective'..."></textarea>
    <br><br>
    <label for="objective"><b>Objective:</b></label><br>
    <textarea id="objective" rows="2" cols="80" placeholder="Waiting for 'Objective'..."></textarea>
    <br><br>
    <label for="assessment"><b>Assessment:</b></label><br>
    <textarea id="assessment" rows="3" cols="80" placeholder="Waiting for 'Assessment'..."></textarea>
    <br><br>
    <label for="plan"><b>Plan:</b></label><br>
    <textarea id="plan" rows="5" cols="80" placeholder="Waiting for 'Plan'..."></textarea>
</body>
</html>