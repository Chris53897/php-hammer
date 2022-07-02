package net.rentalhost.plugins.php.hammer.inspections.flowOptimization

import com.intellij.codeInspection.ProblemsHolder
import com.intellij.psi.PsiElement
import com.intellij.psi.PsiElementVisitor
import com.jetbrains.php.lang.inspections.PhpInspection
import com.jetbrains.php.lang.psi.elements.PhpPsiElement
import com.jetbrains.php.lang.psi.elements.impl.ControlStatementImpl
import com.jetbrains.php.lang.psi.elements.impl.PhpReturnImpl
import net.rentalhost.plugins.services.ElementService
import net.rentalhost.plugins.services.LocalQuickFixService
import net.rentalhost.plugins.services.ProblemsHolderService

class RedundantReturnPointInspection: PhpInspection() {
    override fun buildVisitor(
        problemsHolder: ProblemsHolder,
        isOnTheFly: Boolean
    ): PsiElementVisitor {
        return object: PsiElementVisitor() {
            override fun visitElement(element: PsiElement) {
                if (element is PhpReturnImpl) {
                    val elementConditionalStarter = ElementService.conditionalStarter(element.parent.parent as PhpPsiElement)

                    if (elementConditionalStarter is ControlStatementImpl) {
                        val elementNext = elementConditionalStarter.nextPsiSibling

                        if (elementNext is PhpReturnImpl) {
                            val elementReturn = ElementService.normalizeReturn(problemsHolder.project, element.argument?.text ?: "null")
                            val elementNextReturn = ElementService.normalizeReturn(problemsHolder.project, elementNext.argument?.text ?: "null")

                            if (elementReturn == elementNextReturn) {
                                ProblemsHolderService.registerProblem(
                                    problemsHolder,
                                    element,
                                    "Redundant return point.",
                                    LocalQuickFixService.SimpleDeleteQuickFix("Drop this return point")
                                )
                            }
                        }
                    }
                }
            }
        }
    }
}
