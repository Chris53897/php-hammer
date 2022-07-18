package net.rentalhost.plugins.php.hammer.inspections.flowOptimization

import com.intellij.codeInspection.ProblemsHolder
import com.intellij.psi.PsiElementVisitor
import com.jetbrains.php.lang.inspections.PhpInspection
import com.jetbrains.php.lang.psi.elements.Else
import com.jetbrains.php.lang.psi.elements.If
import com.jetbrains.php.lang.psi.visitors.PhpElementVisitor
import net.rentalhost.plugins.services.FormatterService
import net.rentalhost.plugins.services.ProblemsHolderService

class IfSimplificationElseInspection: PhpInspection() {
    override fun buildVisitor(problemsHolder: ProblemsHolder, isOnTheFly: Boolean): PsiElementVisitor = object: PhpElementVisitor() {
        override fun visitPhpElse(element: Else) {
            val elementParent = element.parent as? If ?: return
            val elementReference = elementParent.elseIfBranches.lastOrNull() ?: elementParent

            val elementNormalized = FormatterService.normalize(
                problemsHolder.project,
                element.statement ?: return
            )

            val elementReferenceNormalized = FormatterService.normalize(
                problemsHolder.project,
                elementReference.statement ?: return
            )

            if (elementNormalized.text != elementReferenceNormalized.text)
                return

            ProblemsHolderService.registerProblem(
                problemsHolder,
                elementReference.firstChild,
                "Useless conditional can be safely dropped."
            )
        }
    }
}
